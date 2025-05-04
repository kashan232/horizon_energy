<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffSalaryController extends Controller
{
    public function index()
{
    $staff = Staff::all();
    $salaryDetails = StaffSalary::with('staff')->get();
    // dd($salaryDetails);
    // Preprocess the data for JavaScript
    $employeeData = $salaryDetails->groupBy('staff.name')->map(function($items) {
        $staff = $items->first()->staff;
        return [
            'salary' => $staff->salary ?? 0,
            'advance' => $items->sum('advance_amount'),
            'history' => $items->mapWithKeys(function($item) {
                return [
                    \Carbon\Carbon::parse($item->payment_date)->format('Y-m') => [
                        'paid' => $item->paid_amount,
                        'date' => $item->payment_date
                    ]
                ];
            })
        ];
    });

    $employeeDataJson = json_encode($employeeData);

    return view('admin_panel.staff_salary.staff_salary', compact('staff', 'salaryDetails', 'employeeDataJson'));
}

    public function getSalaryDetails(Request $request)
    {
        $staff = Staff::findOrFail($request->staff_id);
        $month = Carbon::now()->format('Y-m');

        $salary = StaffSalary::where('staff_id', $staff->id)
                    ->where('month', $month)
                    ->first();

        return response()->json([
            'staff' => $staff,
            'salary' => $salary,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:pay,advance',
        ]);

        $staff = Staff::findOrFail($request->staff_id);
        $month = Carbon::parse($request->payment_date)->format('Y-m');

        // Check if salary for this month already exists
        $salary = StaffSalary::firstOrNew([
            'staff_id' => $staff->id,
            'month' => $month,
        ]);

        if ($request->type === 'pay') {
            // Prevent overpayment
            $totalPaid = $salary->paid_amount + $request->amount;
            if ($totalPaid > $staff->salary) {
                return response()->json(['message' => 'Amount exceeds monthly salary'], 422);
            }
            $salary->paid_amount += $request->amount;
        }

        if ($request->type === 'advance') {
            // Advance allowed only if dues are 0
            if (($staff->salary - $salary->paid_amount) > 0) {
                return response()->json(['message' => 'Clear due salary before giving advance'], 422);
            }
            $salary->advance_amount += $request->amount;
        }

        $salary->payment_date = $request->payment_date;
        $salary->save();

        return response()->json(['message' => 'Transaction recorded successfully']);
    }

}
