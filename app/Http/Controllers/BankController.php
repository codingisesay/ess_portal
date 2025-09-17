<?php
namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('id', 'desc')->get();
        return view('superadmin_view.bank_master', compact('banks'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:banks,name',
            'status' => 'required|string|max:25',
        ]);

        Bank::create($request->only(['name', 'status']));

        return redirect()->route('bank_master')->with('success', 'Bank added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:banks,name,' . $id,
            'status' => 'required|string|max:25',
        ]);

        $bank = Bank::findOrFail($id);
        $bank->update($request->only(['name', 'status']));

        return redirect()->route('bank_master')->with('success', 'Bank updated successfully.');
    }

    public function delete($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return redirect()->route('bank_master')->with('success', 'Bank deleted successfully.');
    }
}
