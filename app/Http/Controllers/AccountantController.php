<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Models\AccountantExpense;
use App\Models\AccountantLedger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountantController extends Controller
{
    public function Accountant()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            // dd($userId);
            $Accountants = Accountant::where('admin_id', '=', $userId)->get();
            return view('admin_panel.Accountants.accountants', [
                'Accountants' => $Accountants
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_Accountant(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Accountant::create([
                'admin_id'    => $userId,
                'name'          => $request->name,
                'Cnic'          => $request->Cnic,
                'Number'          => $request->Number,
                'Address'          => $request->Address,
                'usertype'          => $request->usertype,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Accountant has been  created successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_Accountant(Request $request)
    {
        if (Auth::id()) {
            $update_id = $request->input('Accountant_id');
            $name = $request->input('name');
            $cnic = $request->input('cnic');
            $number = $request->input('number');
            $address = $request->input('address');
            $usertype = $request->input('usertype');

            Accountant::where('id', $update_id)->update([
                'name'      => $name,
                'Cnic'      => $cnic,
                'Number'    => $number,
                'Address'   => $address,
                'usertype'  => $usertype,
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Accountant Updated Successfully');
        } else {
            return redirect()->back();
        }
    }

    public function update_payment(Request $request)
    {
        $accountantId = $request->input('accountant_id');
        $paymentDate = $request->input('payment_date');
        $paymentAmount = $request->input('payment_amount');

        // Ledger Check
        $ledger = AccountantLedger::where('accountant_id', $accountantId)->first();

        if ($ledger) {
            // Agar ledger mojood hai, update karo
            $ledger->update([
                'last_payment_date' => $paymentDate,
                'cash_in_hand' => $ledger->cash_in_hand + $paymentAmount, // Amount Add Hoga
            ]);
        } else {
            // Agar ledger nahi hai, naya record banao
            AccountantLedger::create([
                'accountant_id' => $accountantId,
                'last_payment_date' => $paymentDate,
                'cash_in_hand' => $paymentAmount,
            ]);
        }

        return redirect()->back()->with('success', 'Payment Updated Successfully');
    }

    public function Accountant_Ledger()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $AccountantLedgers = AccountantLedger::with('accountant') // Relation Load kar rahe hain
                ->get();

            return view('admin_panel.Accountants.accountant_ledger', compact('AccountantLedgers'));
        } else {
            return redirect()->back();
        }
    }

    public function Accountant_Expense()
    {
        if (Auth::id()) {
            $userId = Auth::id();

            $Accountants = Accountant::where('admin_id', '=', $userId)->with('expenses')->get();
            $Expenses = AccountantExpense::with('accountant')->get();

            // Accountant ke cash in hand ko lekar aana
            foreach ($Accountants as $accountant) {
                $ledger = AccountantLedger::where('accountant_id', $accountant->id)->first();
                $accountant->cash_in_hand = $ledger ? $ledger->cash_in_hand : 0;
            }

            return view('admin_panel.Accountants.accountant_expense', compact('Accountants', 'Expenses'));
        } else {
            return redirect()->back();
        }
    }


    public function saveExpense(Request $request)
    {
        $request->validate([
            'accountant_id' => 'required|exists:accountants,id',
            'expense_category' => 'required',
            'expense_date' => 'required|date',
            'expense_amount' => 'required|numeric|min:1',
            'expense_description' => 'nullable|string',
        ]);

        // Expense Save
        $expense = new AccountantExpense();
        $expense->accountant_id = $request->accountant_id;
        $expense->expense_category = $request->expense_category;
        $expense->expense_date = $request->expense_date;
        $expense->expense_amount = $request->expense_amount;
        $expense->expense_description = $request->expense_description;
        $expense->save();

        // Ledger Update
        $ledger = AccountantLedger::where('accountant_id', $request->accountant_id)->first();
        if ($ledger) {
            $ledger->cash_in_hand -= $request->expense_amount;
            $ledger->save();
        }

        return redirect()->back()->with('success', 'Expense Added Successfully & Ledger Updated');
    }
}
