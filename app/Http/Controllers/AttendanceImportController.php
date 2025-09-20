<?php
// app/Http/Controllers/AttendanceImportController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginLog;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel as ExcelType;

class AttendanceImportController extends Controller
{
    public function showForm()
    {
        return view('superadmin_view.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'attendance_file' => 'required|mimes:xls,xlsx,csv',
        ]);

        $file = $request->file('attendance_file');

        // Detect file type explicitly
        $extension = strtolower($file->getClientOriginalExtension());
        $readerType = match ($extension) {
            'csv'  => ExcelType::CSV,
            'xls'  => ExcelType::XLS,
            'xlsx' => ExcelType::XLSX,
            default => ExcelType::XLSX,
        };

        // Load first sheet
        $sheet = Excel::toArray([], $file, null, $readerType)[0] ?? [];
        Log::info("Sheet loaded, total rows: " . count($sheet));

        $currentEmpCode = null;
        $currentUserId  = null;
        $insertCount    = 0;

        // 🔎 Detect month & year from the header
        $monthYear = null;
        foreach ($sheet as $row) {
            foreach ($row as $col) {
                if (preg_match('/([A-Za-z]{3})\s+\d{2}\s+(\d{4})/', $col, $m)) {
                    $monthYear = date("Y-m", strtotime($m[1] . " " . $m[2]));
                    Log::info("Detected monthYear = " . $monthYear);
                    break 2;
                }
            }
        }
        if (!$monthYear) {
            $monthYear = date("Y-m");
            Log::warning("⚠️ No month-year detected in sheet. Falling back to $monthYear");
        }

        // Get days in that month for validation
        $daysInMonth = cal_days_in_month(
            CAL_GREGORIAN,
            date("m", strtotime($monthYear . "-01")),
            date("Y", strtotime($monthYear . "-01"))
        );

        foreach ($sheet as $rowIndex => $row) {
            $firstCol = trim($row[0] ?? '');

            // Detect employee block
            if (strpos($firstCol, 'Emp. Code') === 0) {
                // Example: ["Emp. Code:", null, null, "PV0001"]
                $empCode = null;
                foreach ($row as $cell) {
                    if ($cell && preg_match('/^PV\d+$/', trim($cell))) {
                        $empCode = trim($cell);
                        break;
                    }
                }

                $currentEmpCode = $empCode;
                Log::info("Detected employee: " . $currentEmpCode);

                if ($currentEmpCode) {
                    $user = User::where('employeeID', $currentEmpCode)->first();
                    $currentUserId = $user?->id;
                    Log::info("Mapped to user_id = " . $currentUserId);
                }
                continue;
            }

            // Process InTime / OutTime rows
            if ($currentUserId && $firstCol === 'InTime') {
                $inTimes     = array_slice($row, 1);
                $outTimesRow = $sheet[$rowIndex + 1] ?? [];
                $outTimes    = array_slice($outTimesRow, 1);

                foreach ($inTimes as $dayIndex => $inTime) {
                    $inTime  = trim($inTime ?? '');
                    $outTime = trim($outTimes[$dayIndex] ?? '');

                    if ($inTime !== '' || $outTime !== '') {
                        $day = $dayIndex + 1;

                        // ✅ skip invalid days (e.g. 33, or 31 in February)
                        if ($day > $daysInMonth) {
                            Log::warning("Skipping invalid day $day for $monthYear (max $daysInMonth)");
                            continue;
                        }

                        $loginDate = $monthYear . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

                        $loginDateTime  = $inTime ? date("Y-m-d H:i:s", strtotime("$loginDate $inTime")) : null;
                        $logoutDateTime = $outTime ? date("Y-m-d H:i:s", strtotime("$loginDate $outTime")) : null;

                        LoginLog::updateOrCreate(
                            ['user_id' => $currentUserId, 'login_date' => $loginDate],
                            [
                                'login_time'  => $loginDateTime,
                                'logout_time' => $logoutDateTime,
                            ]
                        );

                        $insertCount++;
                        Log::info("Inserted/updated: user_id=$currentUserId, date=$loginDate");
                    }
                }
            }
        }

        return back()->with('success', "Attendance Imported Successfully! ($insertCount records processed)");
    }
}
