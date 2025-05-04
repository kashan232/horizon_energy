<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $expenses = Expense::where('admin_or_user_id', '=', $userId)->get();
            return view('admin_panel.expenses.index', [
                'expenses' => $expenses
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_expense(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::id()) {
            $userId = Auth::id(); // Get the authenticated user ID

            // Create a new expense
            Expense::create([
                'admin_or_user_id' => $userId, // Store the user ID as the associated ID
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Expense created successfully');
        } else {
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::id()) {
            $userId = Auth::id(); // Get the authenticated user ID

            // Get the expense ID from the request
            $expenseId = $request->input('expense_id');

            // Update the expense data
            Expense::where('id', $expenseId)->update([
                'title' => $request->input('title'),
                'amount' => $request->input('amount'),
                'date' => $request->input('date'),
                'description' => $request->input('description'),
                'updated_at' => Carbon::now(),
            ]);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Expense updated successfully');
        } else {
            return redirect()->back();
        }
    }
}
