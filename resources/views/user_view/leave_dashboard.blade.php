@extends('user_view.header')
@section('content')
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Leave & Attendance Dashboard</title> --}}
    {{-- <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('user_end/css/leave.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.min.css" rel="stylesheet">

        
    <div class="m-3">
    @if($errors->any())
    <div class="alert custom-alert-warning">
    <ul>
    @foreach($errors->all() as $error)
    <li style="color: red;">{{ $error }}</li>

    @endforeach
    </ul>
    </div>
    @endif
    <!-- <div class="d-flex justify-content-between align-items-center"> 
        <button class="apply-leave" onclick="redirectToForm()">Apply Leave</button>
    </div>  -->
    <script>


        function redirectToForm() {
            window.location.href = '{{route('leave_request')}}'; // Replace with the actual form URL
        }
    </script>
    <?php
// dd($appliedLeaves);
?>
    <div class="main">
        <div class="left-sec">
            <div class="one row mx-auto"> 
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="attendance-header p-3">
                        <h5 class="mb-0">Average Working Hours</h5>
                        <hr class="my-2"  >
                        <canvas id="attendanceChart" style="width: 600px; height: 450px;"></canvas>
                        <script>
                            // Passing PHP variables into JavaScript using Blade
                            const attendanceData = {
                                dates: @json(array_column($workingHoursData['working_hours'], 'date')),  // Extract dates array
                                hours: @json(array_column($workingHoursData['working_hours'], 'worked_hours'))  // Extract hours array
                            };

                            // console.log(attendanceData);

                            const ctx = document.getElementById('attendanceChart').getContext('2d');
                            const attendanceChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: attendanceData.dates,  // Dates array passed from PHP
                                    datasets: [{
                                        label: 'Hours Worked',
                                        data: attendanceData.hours,  // Hours array passed from PHP
                                        backgroundColor: '#0E8D4A',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Hours Worked'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Date'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true
                                        }
                                    },
                                    barThickness: 'flex',
                                    categoryPercentage: 0.6,
                                    barPercentage: 0.6
                                }
                            });
                        </script>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="attendance-header p-3">
                        <h5 class="mb-0">Work From Home Trend</h5><hr class="my-2"  >
                        <div class="chart-container1" style="width: 100%; text-align: center; background-color:white; ">
                            <div style="width:80%" class="mx-auto mb-2">
                                <canvas id="workFromHomeChartCanvas" height="240"></canvas>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <small class="text-secondary">
                                    Total WFH days (last 6 months): <strong>{{ rtrim(rtrim(number_format($workFromHomeTotalDays, 2, '.', ''), '0'), '.') }}</strong>
                                </small>
                            </div>
                        </div>
                        <script>
                            // Render the dynamic WFH dataset provided by the controller
                            const workFromHomeChartData = @json($workFromHomeChart);
                            const wfhCtx = document.getElementById('workFromHomeChartCanvas').getContext('2d');
                            new Chart(wfhCtx, {
                                type: 'bar',
                                data: {
                                    labels: workFromHomeChartData.labels,
                                    datasets: [{
                                        label: 'WFH Days',
                                        data: workFromHomeChartData.data,
                                        backgroundColor: '#8a3366',
                                        borderRadius: 6,
                                    }]
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function(value) {
                                                    return value + ' d';
                                                }
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return context.parsed.y + ' days';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">  
                    <div class="attendance-header p-3">
                        <h5 class="mb-0">Leave Type</h5><hr class="my-2"  >
                        <div class="leave-type-collection">
                            @foreach($leaveSummary as $leave)
                                <button class="button" style="background-color: {{ $loop->index % 2 == 0 ? '#8a3366' : '#2B53C1' }};">
                                    {{ $leave['leave_type'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                 
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="attendance-header p-3">
                        <h5 class="mb-0">Upcoming Holidays</h5><hr class="my-2"  >
                        <div class="holidays">
                            <div class="container-holiday">
                                <ul class="holiday-list">
                                    @if ($holidays_upcoming->isNotEmpty())
                                        @foreach ($holidays_upcoming as $holiday)
                                            <li class='holiday-item highlight'>
                                                <span class="date1 yellow-box">
                                                    {{ \Carbon\Carbon::parse($holiday->formatted_date)->format('d M') }}
                                                </span>
                                                <span class="holiday-name">
                                                    <strong>{{ $holiday->holiday_name }}</strong>
                                                    <p>{{ $holiday->day }}</p> 
                                                </span>
                                            </li>  
                                        @endforeach
                                    @else
                                        <li class='holiday-item'>
                                            <span class="holiday-name text-muted">
                                                No upcoming holidays this year.
                                            </span>
                                        </li>
                                    @endif
                                </ul> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3 d-flex"> 
                    <div class="summary p-3 h-100 d-flex flex-column w-100">
                        <h5 class="mb-0">Leave Summary</h5>
                        <hr class="my-2"  >
                        <div class="leave-summary-container row justify-content-around">
                            <!-- Leave cards will be dynamically inserted here -->
                            @foreach($leaveSummary as $index => $leave)
                            
                            @endforeach
                        </div>

                        <script>
                            const leaveData = @json($leaveSummary);  // Pass the leave summary data to JavaScript

                            // console.log(leaveData); // Check the data in the console to ensure no duplicates

                            const colorPalette = [
                                ['#8a3366', '#ffc107'], // Two colors: Total Leaves and Consumed Leaves
                                ['#2B53C1', '#ffc107']
                            ];

                            const container = $('.leave-summary-container');

                            leaveData.forEach((leave, index) => {
                                const totalLeaves = leave.total_leaves;
                                const consumed = leave.consumed_leaves || 0;
                                const [availableColor, consumedColor] = colorPalette[index % colorPalette.length];

                                const cardHtml = `
                                <div class="col-md-5">
                                    <div class="leave-card ">
                                        <div class="chart-container-leave">
                                            <canvas id="chart${index}"  width="130px" height="200px"></canvas>
                                        </div>
                                        <div class="legend">
                                            <h6>${leave.leave_type}</h6>
                                            <div class="chart-lable"><span class="dot" style="background-color:${availableColor}"></span>${totalLeaves} Total Leaves</div>
                                            <div class="chart-lable"><span class="dot" style="background-color:${consumedColor}"></span>${consumed} Consumed</div>
                                        </div>
                                    </div>
                                    </div>
                                `;

                                container.append(cardHtml);

                                const ctx = document.getElementById(`chart${index}`).getContext('2d');

                                new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        datasets: [{
                                            data: [totalLeaves, consumed],
                                            backgroundColor: [availableColor, consumedColor],
                                            borderColor: [availableColor, consumedColor],
                                            borderWidth: 2,
                                            offset: 20
                                        }]
                                    },
                                    options: {maintainAspectRatio: false, // Add this
                                        responsive: true,
                                        cutout: '50%',
                                        rotation: Math.PI / 2.8,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function (tooltipItem) {
                                                        // tooltipItem.raw gives the value of the current slice
                                                        const total = tooltipItem.dataset.data[0] + tooltipItem.dataset.data[1];  // 24 + 0.5 = 24.5

                                                        // Calculate percentage
                                                        const percentage = Math.round((tooltipItem.raw / total) * 100);  

                                                        // Return both value and percentage
                                                        return `${tooltipItem.raw} (${percentage}%)`;  // Shows value and percentage
                                                    }
                                                }
                                            }                
                                        }
                                    }
                                });
                            });
                        </script>
                        <br>
                    </div>
                </div>
                                    
                <div class="col-md-6 mb-3 d-flex">
                    <div class="applied-leaves p-3 d-flex flex-column h-100 w-100">
                        <h5 class="mb-0 d-flex justify-content-between align-items-center">
                            <span class="me-auto" > Applied Leave</span>
                            <small class="apply-leave py-1 px-4" onclick="redirectToForm()">Apply Leave</small></h5>  
                        <hr class="my-2"  >
                        <div class="applied-scroll flex-grow-1 overflow-auto">
                            <div class="container">
                                @foreach($appliedLeaves as $leave)
                                    <div class="status-item">
                                        <div>
                                            <span class="date">
                                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d F, Y') }} - 
                                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d F, Y') }}
                                            </span><br>
                                            <span class="note">{{ $leave->description }}</span>
                                        </div>
                                        <small> {{ $leave->leave_approve_status }}</small>
                        
                                        @if(($leave->leave_approve_status == 'Pending' || $leave->leave_approve_status == 'Approved') && \Carbon\Carbon::parse($leave->start_date) > today())
                                            <!-- Form to cancel the leave -->
                                        
                                            <form id="cancelForm-{{ $leave->id }}" action="{{ route('update_leave_status_by_user',['id' => $leave->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <span class="text-danger mt-4 me-3" type="button" onclick="showConfirmPopup('cancelForm-{{ $leave->id }}')">
        <x-icon name="trash" />
    </span>
</form>
                                        @endif
                                    </div>
                                @endforeach 
                            </div>
                        </div>
                    </div>

                    <script>
                     

                        function showConfirmPopup(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to cancel the operation?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Cancel it!',
        cancelButtonText: 'No, Keep it',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelled',
                'Your operation is safe.',
                'info'
            );
        }
    });
}
                    </script>
                </div>

                <!-- Full-width: make Attendance Overview span the entire row for better visibility -->
                <div class="col-12 mb-3">              
                    <div class="attendance p-3">
                        <h5 class="mb-0">Attendance Overview</h5> <hr class="my-2"  >
                            <!-- Responsive chart: canvas width set to 100% to fill available horizontal space -->
                            <canvas id="newAttendanceChart" style="width: 100%; height: 430px;"></canvas>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const newCtx = document.getElementById('newAttendanceChart').getContext('2d');

                                    // Fetch the attendance data from the Blade variable
                                    const attendanceData = @json($attendanceOverview);

                                    // Extract month labels
                                    const months = Object.keys(attendanceData).map(month => {
                                        return new Date(2025, month - 1, 1).toLocaleString('en-US', { month: 'long' });
                                    });

                                    // Extract on-time, late, and absent data
                                    const onTimeData = Object.values(attendanceData).map(data => data.on_time || 0);
                                    const lateData = Object.values(attendanceData).map(data => data.late || 0);
                                    const absentData = Object.values(attendanceData).map(data => data.absent || 0);

                                    // Determine the max y-axis value for better scaling
                                    const maxDays = Math.max(...Object.values(attendanceData).flatMap(obj =>
                                        [obj.on_time || 0, obj.late || 0, obj.absent || 0]
                                    ));

                                    new Chart(newCtx, {
                                        type: 'bar',
                                        data: {
                                            labels: months,
                                            datasets: [
                                                { label: 'On Time', data: onTimeData, backgroundColor: '#8A3366' },
                                                { label: 'Late', data: lateData, backgroundColor: '#E0AFA0' },
                                                { label: 'Absent', data: absentData, backgroundColor: '#D9D9D9' }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(tooltipItem) {
                                                            let datasetLabel = tooltipItem.dataset.label || '';
                                                            let value = tooltipItem.raw;
                                                            return `${datasetLabel}: ${value} days`;
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                x: { stacked: true },
                                                y: { stacked: true, beginAtZero: true, suggestedMax: maxDays }
                                            }
                                        }
                                    });
                                });
                            </script>

                    </div> 
                </div>
                
                

                <div class="col-12 mb-3">  
                    <div class="attendance-header p-3 ">
                        <h5 class="mb-0">Leave Balance Summary</h5><hr class="my-2"  >
                        <table>
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Entitled Days</th>
                                    <th>Carry Forward</th>
                                    <th>Encash</th>
                                    <th>Taken Leaves</th>
                                    <th>Remaining Leave</th>
                                    <th>Loss of Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaveSummary as $leave)
                                    <tr>
                                        <td>{{ $leave['leave_type'] }}</td>
                                        <td>{{ rtrim(rtrim(number_format($leave['total_leaves'], 2, '.', ''), '0'), '.') }} days</td>
                                        <td>{{ rtrim(rtrim(number_format($leave['no_carry_forward'], 2, '.', ''), '0'), '.') }} days</td>
                                        <td>{{ rtrim(rtrim(number_format($leave['no_leave_encash'], 2, '.', ''), '0'), '.') }} days</td>
                                        <td>{{ rtrim(rtrim(number_format($leave['consumed_leaves'], 2, '.', ''), '0'), '.') }} days</td>
                                        <td>{{ rtrim(rtrim(number_format($leave['remaining_leaves'], 2, '.', ''), '0'), '.') }} days</td>
                                        <td>0 days</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
 
            </div> 
        </div>
    </div>


</div>

@endsection