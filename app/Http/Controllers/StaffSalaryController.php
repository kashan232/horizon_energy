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
        $staff = Staff::all();  // Get all staff records
        $salaryDetails = StaffSalary::with('staff')->get();  // Get all salary details
    
        // Preprocess the salary data for each staff member
        $employeeData = $salaryDetails->groupBy('staff_id')->mapWithKeys(function($items, $staffId) {
            // Ensure we get the staff object
            $staff = $items->first()->staff;
    
            // If staff doesn't exist, skip it
            if (!$staff) {
                return [];
            }
    
            return [
                $staffId => [
                    'name' => $staff->name,
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
                ]
            ];
        });
    
        // Ensure all staff members exist in the employeeData array
        foreach ($staff as $person) {
            if (!isset($employeeData[$person->id])) {
                $employeeData[$person->id] = [
                    'name' => $person->name,
                    'salary' => $person->salary,
                    'advance' => 0,
                    'history' => []
                ];
            }
        }
    
        // Pass the data to the view
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
            'payment_date' => 'required|date',
        ]);
    
        $staff = Staff::findOrFail($request->staff_id);
        $paymentDate = Carbon::parse($request->payment_date);
        $month = $paymentDate->format('Y-m');
    
        $salary = StaffSalary::firstOrNew([
            'staff_id' => $staff->id,
            'month' => $month,
        ]);
    
        $salary->staff_date = $paymentDate->format('Y-m-d');
        $salary->staff_month = $paymentDate->format('F');
        $salary->payment_date = $paymentDate;
    
        if ($request->type === 'pay') {
            $totalPaid = $salary->paid_amount + $request->amount;
    
            if ($totalPaid > $staff->salary) {
                return response()->json(['message' => 'Amount exceeds monthly salary'], 422);
            }
    
            $salary->paid_amount = $totalPaid;
            $salary->remarks = "Salary paid";
    
            // ✅ Set status
            if ($totalPaid == $staff->salary) {
                $salary->status = "paid";
            } elseif ($totalPaid > 0 && $totalPaid < $staff->salary) {
                $salary->status = "partial";
            } else {
                $salary->status = "unpaid";
            }
        }
    
        if ($request->type === 'advance') {
            if (($staff->salary - $salary->paid_amount) > 0) {
                return response()->json(['message' => 'Clear due salary before giving advance'], 422);
            }
    
            $salary->advance_amount += $request->amount;
            $salary->remarks = "Advance given";
            $salary->status = "advance";
        }
    
        $salary->due_amount = $staff->salary - $salary->paid_amount;
    
        $salary->save();
    
        return response()->json(['message' => 'Transaction recorded successfully']);
    }
    
    

}
