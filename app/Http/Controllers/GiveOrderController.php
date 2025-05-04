<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\VendorLedger;


class GiveOrderController extends Controller
{
        public function vendor(Request $request)
    {
        $vendors = Vendor::all();
        $orders = Order::whereNotIn('order_status', ['Deliver', 'Cancelled'])->get();

        $query = VendorLedger::with('vendor');

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'paid') {
                $query->where('remaining_amount', 0);
            } elseif ($request->payment_status === 'remaining') {
                $query->where('remaining_amount', '>', 0);
            }
        }

        $ledgers = $query->latest()->paginate(10); // ✅ Apply paginate AFTER filters

        return view('admin_panel.vendor.give_order', compact('vendors', 'orders', 'ledgers'));
    }

    
    
    // Naya Vendor store karna
    public function store_vendor(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required',
            'order_id' => 'required',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
        ]);

        $remaining = $request->total_amount - $request->paid_amount;

        VendorLedger::create([
            'vendor_id' => $request->vendor_id,
            'order_id' => $request->order_id,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'remaining_amount' => $remaining,
        ]);

        // (Optional) Order ko assign bhi kar sakte ho
        Order::where('id', $request->order_id)->update(['assigned_vendor_id' => $request->vendor_id]);

        return redirect()->route('vendor')->with('success', 'Order Assigned Successfully!');
    }
    // Vendor update karna
    public function update_vendor(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $vendor = Vendor::find($request->vendor_id);
        $vendor->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Vendor updated successfully.');
    }

    // Vendor ko Order assign karna + Ledger Update
    // public function assignOrderToVendor(Request $request)
    // {
    //     $request->validate([
    //         'vendor_id'      => 'required|exists:vendors,id',
    //         'order_id'       => 'required|exists:orders,id',
    //         'total_amount'   => 'required|numeric',
    //         'paid_amount'    => 'required|numeric',
    //         'remaining_amount' => 'required|numeric',
    //     ]);

    //     // Update Order with assigned Vendor
    //     $order = Order::find($request->order_id);
    //     $order->vendor_id = $request->vendor_id;
    //     $order->vendor_assigned = true; // Tum is tarah ka column bana lena
    //     $order->save();

    //     // Create Ledger entry
    //     VendorLedger::create([
    //         'vendor_id'        => $request->vendor_id,
    //         'order_id'         => $request->order_id,
    //         'total_amount'     => $request->total_amount,
    //         'paid_amount'      => $request->paid_amount,
    //         'remaining_amount' => $request->remaining_amount,
    //     ]);

    //     return back()->with('success', 'Order assigned to vendor successfully.');
    // }
}
