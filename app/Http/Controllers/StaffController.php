<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    
    public function staff()
{
    if (Auth::id()) {
        $userId = Auth::id();

        // Sirf admin_id ke basis par staff fetch karna (usertype check hataya gaya hai)
        $staffs = Staff::where('admin_id', '=', $userId)->get();

        return view('admin_panel.staff.staff', [
            'staffs' => $staffs
        ]);
    } else {
        return redirect()->back();
    }
}

public function store_staff(Request $request)
{
    if (Auth::id()) {
        $userId = Auth::id();

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'phone' => 'required|string|max:20',
        //     'email' => 'required|email|max:255',
        //     'usertype' => 'required|string|max:255',
        //     'salary' => 'required|numeric',
        //     'total_due' => 'required|numeric',
        //     'last_payment_date' => 'required|date',
        // ]);

        Staff::create([
            'admin_id'          => $userId,
            'name'              => $request->name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'usertype'          => $request->usertype,
            'salary'            => $request->salary,
            'total_due'         => $request->total_due,
            'last_payment_date' => $request->last_payment_date,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Staff has been created successfully');
    } else {
        return redirect()->back();
    }
}

    public function update_staff(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
    
        // $request->validate([
        //     'staff_id' => 'required|exists:staff,id',
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        //     'phone' => 'nullable|string|max:20',
        //     'usertype' => 'required|string|max:255',
        // ]);
    
        Staff::where('id', $request->staff_id)->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'usertype'   => $request->usertype,
            'updated_at' => Carbon::now(),
        ]);
    
        return redirect()->back()->with('success', 'Staff updated successfully.');
    }
    
    
}
