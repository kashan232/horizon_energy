<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;


class VendorController extends Controller
{
    public function vendor()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId); 
            $Vendors = Vendor::get();
            return view('admin_panel.vendor.vendors', [
                'Vendors' => $Vendors
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_vendor(Request $request)
    {
        // dd($request->toArray());
        $lastvendor = Vendor::latest('id')->first(); // Last customer ka ID find karega
        $nextId = $lastvendor ? $lastvendor->id + 1 : 1; // Agar koi customer nahi mila toh 1 set karega
        
        // dd('CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT));
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Vendor::create([
                'name'          => $request->vendor_name,
                'role'          => $request->role,
                'phone'          => $request->vendor_phone,
                'address'          => $request->vendor_address,
                'identity'          => 'Vend-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
            ]);
            return redirect()->back()->with('success', 'Vendor has been  created successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_vendor(Request $request)
    {
        dd($request);
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($request);
            $update_id = $request->input('customer_id');
            $name = $request->input('customer_name');
            $email = $request->input('customer_email');
            $phone = $request->input('customer_phone');
            $address = $request->input('customer_address');

            Vendor::where('id', $update_id)->update([
                'customer_name'          => $name,
                'customer_email'          => $email,
                'customer_phone'          => $phone,
                'customer_address'          => $address,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Customer Updated Successfully');
        } else {
            return redirect()->back();
        }
    }

}
