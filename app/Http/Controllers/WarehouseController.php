<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    
    public function warehouse()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $Warehousses = Warehouse::where('admin_or_user_id', '=', $userId)->get();
            return view('admin_panel.warehouse.warehouse', [
                'Warehousses' => $Warehousses
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_warehouse(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Warehouse::create([
                'admin_or_user_id'    => $userId,
                'name'          => $request->name,
                'address'          => $request->address,
                'status'          => 'Enabled',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Warehouse Added Successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_warehouse(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($request);
            $update_id = $request->input('warehouse_id');
            $name = $request->input('name');
            $address = $request->input('address');

            Warehouse::where('id', $update_id)->update([
                'admin_or_user_id'    => $userId,
                'name'          => $name,
                'address'          => $address,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Warehouse Updated Successfully');
        } else {
            return redirect()->back();
        }
    }

}
