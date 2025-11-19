<?php
namespace App\Http\Controllers;

use App\Models\bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(Request $request)
    {
        // Get sort parameters from URL or use defaults
        // 'id' is the default sort column if none specified
        // 'desc' is the default sort order if none specified
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        
        // Fetch banks with dynamic sorting based on the parameters
        $banks = Bank::orderBy($sort, $order)->get();
        
        // Pass banks and sort parameters to the view
        return view('superadmin_view.bank_master', compact('banks', 'sort', 'order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:banks,name',
            'status' => 'required|string|max:25',
        ]);

        Bank::create($request->only(['name', 'status']));

        return redirect()->route('bank_list')->with('success', 'Bank added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:banks,name,' . $id,
            'status' => 'required|string|max:25',
        ]);

        $bank = Bank::findOrFail($id);
        $bank->update($request->only(['name', 'status']));

        return redirect()->route('bank_list')->with('success', 'Bank updated successfully.');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return redirect()->route('bank_list')->with('success', 'Bank deleted successfully.');
    }
}
