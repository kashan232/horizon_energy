<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\MenuEstimate;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuEstimateController extends Controller
{
    
    public function all_menu()
    {

        // dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            $orders = MenuEstimate::where('user_id', '=', $userId)->get();
            return view('admin_panel.menu_estimate.all_order', compact('orders'));
        } else {
            return redirect()->back();
        }

    }

    public function add_menu()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = Product::get();
            $Customers = Customer::get();
            $Category = Category::get();

            return view('admin_panel.menu_estimate.add_order', compact('all_product', 'Customers', 'Category'));
        } else {
            return redirect()->back();
        }
    }

    public function store_menu(Request $request)
    {
        if (Auth::id()) {
            $userId = Auth::id();

            // Total price aur payable amount calculate karna
            $totalPrice = $request->input('total_price', 0);
            $discount = $request->input('discount', 0);
            $payableAmount = $totalPrice - $discount;

            // Order ka array prepare karna
            $orderData = [
                'user_id' => $userId,
                'customer_name' => $request->input('customer_name'),
                'oppertunity_officer' => $request->input('oppertunity_officer'),
                'estimate_date' => $request->input('estimate_date', ''), // sale_date ko estimate_date banana
                'starting_date' => $request->input('starting_date', ''), // delivery_date ko starting_date banana
                'location' => $request->input('location', ''), // event_type ya Venue yahan la sakte ho
                'phone' => $request->input('phone', ''), // event_type ya Venue yahan la sakte ho
                'system_size' => $request->input('system_size', ''), // person_program ya koi custom field
                'item_category' => json_encode($request->input('item_category', [])),
                'item_subcategory' => json_encode($request->input('item_subcategory', [])),
                'item_name' => json_encode($request->input('item_name', [])),
                'unit' => json_encode($request->input('unit', [])),         
                'quantity' => json_encode($request->input('quantity', [])),
                'price' => json_encode($request->input('price', [])),
                'total' => json_encode($request->input('total', [])),
                'total_price' => $totalPrice,
                'status' => 'pending', // ya default koi status set karna
            ];
            // Order create karna
            MenuEstimate::create($orderData);

            return redirect()->back()->with('success', 'Order successfully saved!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized access!');
        }
    }

    public function show($id)
    {
        $order = MenuEstimate::findOrFail($id);
        // dd($order);
        $allCategories = Category::pluck('category', 'id')->toArray();
        return view('admin_panel.menu_estimate.invoice', compact('order', 'allCategories'));
    }
    public function confirmOrder(Request $request)
    {
        $estimateId = $request->estimate_id;
    
        DB::beginTransaction();
    
        try {
            // Find estimate
            $estimate = MenuEstimate::findOrFail($estimateId);
    
            // Directly create new order, no check for existing orders
            $order = new Order();
            $order->user_id = $estimate->user_id;
            $order->customer_name = $estimate->customer_name;
            $order->sale_date = $estimate->sale_date;
            $order->delivery_date = $estimate->delivery_date;
            $order->event_type = $estimate->event_type;
            $order->Venue = $estimate->Venue;
            $order->person_program = $estimate->person_program;
            $order->item_category = $estimate->item_category;
            $order->item_subcategory = $estimate->item_subcategory;
            $order->item_name = $estimate->item_name;
            $order->unit = $estimate->unit;
            $order->quantity = $estimate->quantity;
            $order->price = $estimate->price;
            $order->total = $estimate->total;
            $order->total_price = $estimate->total_price;
    
            // Default values
            $order->order_name = null;
            $order->delivery_time = null;
            $order->special_instructions = null;
            $order->note = null;
            $order->discount = 0;
            $order->payable_amount = $estimate->total_price;
            $order->advance_paid = 0;
            $order->remaining_amount = $estimate->total_price;
            $order->order_status = 'confirmed';
            $order->payment_status = 'pending';
            $order->order_type = 'menu';
    
            $order->save();
    
            // Update estimate status to "Confirmed" (you were using 1, that's fine if 1 means Confirmed in your system)
            $estimate->status = '1';
            $estimate->save();
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Order confirmed successfully!'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }
    
        

}
