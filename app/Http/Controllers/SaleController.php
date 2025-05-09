<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerCredit;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // If using barryvdh/laravel-dompdf

class SaleController extends Controller
{

    public function Sale()
    {

    $Purchase = Sale::whereNull('change_return')->get();
    // dd($salesReturns);
    return view('admin_panel.sale.sales', compact('Purchase'));
}


    public function add_Sale()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $Customer = Customer::get();
            $Warehouse = Warehouse::get();
            $Categor = Category::get();

            return view('admin_panel.sale.add_sale', [
                'Customers' => $Customer,
                'Warehouses' => $Warehouse,
                'Category' => $Categor,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getItemsByCategory($categoryId)
    {
        $items = Product::where('category', $categoryId)->get(); // Adjust according to your database structure
        return response()->json($items);
    }
    // public function salesreturn($id)
    // {
    //     if (Auth::id()) {
    //         $userId = Auth::id();

    //         $Customers = Customer::get();
    //         $sale = Sale::where('id', $id)->first();

    //         if ($sale) {
    //             $itemNames = json_decode($sale->item_name, true);
    //             $quantities = json_decode($sale->quantity, true);
    //             $prices = json_decode($sale->price, true);
    //             $totals = json_decode($sale->total, true);

    //             $stocks = [];
    //             foreach ($itemNames as $itemName) {
    //                 $product = Product::where('name', $itemName)->first();
    //                 $stocks[] = $product ? $product->stock : 0;
    //             }

    //             return view('admin_panel.sale.return_sale', [

    //                     'sale' => $sale,
    //                     'Customers' => $Customers,
    //                     'itemNames' => $itemNames,
    //                     'quantities' => $quantities,
    //                     'prices' => $prices,
    //                     'totals' => $totals,
    //                     'stocks' => $stocks
    //                 ]);

    //         } else {
    //             return redirect()->back()->with('error', 'Sale not found');
    //         }
    //     } else {
    //         return redirect()->back();
    //     }
    // }
    //------start sales retunn code
    
    function storeSalesReturn(Request $request){
            // Find the sale by ID
            $sale = Sale::find($request->sales_id);

            // Update the 'note' and 'change_return' fields
            $sale->note = $request->note;
            $sale->change_return = now();;


            $sale->save();

            return redirect()->route('Sale')->with('success', 'Sale updated successfully');
    }
    function Salereturnview(){
            $Purchase = Sale::whereNotNull('change_return')->get();
    return view('admin_panel.sale.sales_return_view', compact('Purchase'));
    }
    // -----------sales return code end
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $Customers = Customer::all(); // or whatever model you use
        $Warehouses = Warehouse::all();
        $Category = Category::all();

        return view('admin_panel.sale.edit-sale', compact('sale', 'Customers', 'Warehouses', 'Category'));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $discount = (float) $request->input('discount', 0);
        $totalPrice = (float) $request->input('total_price', 0);
        $netTotal = $totalPrice - $discount;

        // Extract ID from "id|name"
        $customerParts = explode('|', $request->input('customer_info'));
        $customerId = $customerParts[0];

        $sale->update([
            'customerId' => $customerId,
            'sale_date' => $request->input('sale_date'),
            'warehouse_id' => $request->input('warehouse_id'),
            'item_category' => json_encode($request->input('item_category', [])),
            'item_name' => json_encode($request->input('item_name', [])),
            'quantity' => json_encode($request->input('quantity', [])),
            'price' => json_encode($request->input('price', [])),
            'total' => json_encode($request->input('total', [])),
            'note' => $request->input('note', ''),
            'total_price' => $totalPrice,
            'discount' => $discount,
            'Payable_amount' => $netTotal,
            'cash_received' => $request->input('cash_received', 0),
           'change_return' => $request->filled('change_to_return') ? $request->input('change_to_return') : null,

        ]);

        return redirect()->route('sale-receipt', ['id' => $sale->id])->with('success', 'Sale updated successfully.');
    }

    public function view($id)
    {
        // Fetch the purchase record
        $purchase = \App\Models\Purchase::findOrFail($id);

        // Decode JSON fields safely (to array)
        $purchase->item_category = is_array($purchase->item_category) ? $purchase->item_category : json_decode($purchase->item_category, true);
        $purchase->item_name = is_array($purchase->item_name) ? $purchase->item_name : json_decode($purchase->item_name, true);
        $purchase->quantity = is_array($purchase->quantity) ? $purchase->quantity : json_decode($purchase->quantity, true);
        $purchase->price = is_array($purchase->price) ? $purchase->price : json_decode($purchase->price, true);
        $purchase->total = is_array($purchase->total) ? $purchase->total : json_decode($purchase->total, true);

        // Fetch category and product names using IDs
        $categoryIds = $purchase->item_category ?? [];
        $productIds = $purchase->item_name ?? [];

        $categories = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id'); // replace 'category_name' with your actual column
        $products = \App\Models\Product::whereIn('id', $productIds)->pluck('name', 'id');     // replace 'product_name' with your actual column

        return view('admin_panel.purchase.view', [
            'purchase' => $purchase,
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function store_Sale(Request $request)
    {
        // Removed dd($request->all());
        $invoiceNo = Sale::generateInvoiceNo();
        // \Log::info('Request Data:', $request->all());

        $discount = (float)($request->input('discount', 0));
        $totalPrice = (float)$request->input('total_price', 0);
        $cashReceived = (float)$request->input('cash_received', 0);
        $changeToReturn = (float)$request->input('change_to_return', 0);

        // \Log::info('Processed Values:', [
        //     'discount' => $discount,
        //     'total_price' => $totalPrice,
        //     'cash_received' => $cashReceived,
        //     'change_to_return' => $changeToReturn,
        // ]);

        $usertype = Auth()->user()->usertype;
        $userId = Auth::id();

        $itemNames = $request->input('item_name', []);
        $itemCategories = $request->input('item_category', []);
        $quantities = $request->input('quantity', []);

        // Validate stock for all products
        foreach ($itemNames as $key => $item_name) {
            $item_category = $itemCategories[$key] ?? '';
            $quantity = $quantities[$key] ?? 0;

            $product = Product::where('name', $item_name)
                ->where('category_id', $item_category)
                ->first();

            if (!$product) {
                return redirect()->back()->with('error', "Product $item_name in category $item_category not found.");
            }

            if ($product->stock < $quantity) {
                return redirect()->back()->with('error', 'Insufficient stock for ' . $item_name . '. Available: ' . $product->stock . ', Required: ' . $quantity . '.');
            }
        }

        // Get customer info
        $customerInfo = explode('|', $request->input('customer_info'));
        if (count($customerInfo) < 2) {
            return redirect()->back()->with('error', 'Invalid customer information.');
        }

        $customerId = $customerInfo[0];
        $customerName = $customerInfo[1];

        // Calculate net total
        $discount = (float) $request->input('discount', 0);
        $totalPrice = (float) $request->input('total_price', 0);
        $netTotal = $totalPrice - $discount;

        // Handle customer credit
        $customerCredit = CustomerCredit::where('customerId', $customerId)->first();

        $previousBalance = 0;
        $closingBalance = $netTotal;

        if ($customerCredit) {
            $previousBalance = $customerCredit->previous_balance;
            $closingBalance = $previousBalance + $netTotal;

            $customerCredit->update([
                'net_total' => $netTotal,
                'closing_balance' => $closingBalance,
                'previous_balance' => $closingBalance,
            ]);
        } else {
            // Corrected previous_balance to 0 for new customers
            CustomerCredit::create([
                'customerId' => $customerId,
                'customer_name' => $customerName,
                'previous_balance' => 0, // Fixed here
                'net_total' => $netTotal,
                'closing_balance' => $netTotal,
            ]);
        }

        // Save sale data
        $saleData = [
            'userid' => $userId,
            'user_type' => $usertype,
            'invoice_no' => $invoiceNo,
            'customerId' => $customerId,
            'customer' => $customerName,
            'sale_date' => $request->input('sale_date'),
            'warehouse_id' => $request->input('warehouse_id'),
            'item_category' => json_encode($request->input('item_category', [])),
            'item_name' => json_encode($request->input('item_name', [])),
            'quantity' => json_encode($request->input('quantity', [])),
            'price' => json_encode($request->input('price', [])),
            'total' => json_encode($request->input('total', [])),
            'note' => $request->input('note', ''),
            'total_price' => $totalPrice,
            'discount' => $discount,
            'Payable_amount' => $netTotal,
            'cash_received' => $cashReceived,
            'change_return' => $request->filled('change_to_return') ? $request->input('change_to_return') : null,
        ];

        $sale = Sale::create($saleData);

        // Deduct stock
        foreach ($itemNames as $key => $item_name) {
            $item_category = $itemCategories[$key] ?? '';
            $quantity = $quantities[$key] ?? 0;

            $product = Product::where('name', $item_name)
                ->where('category_id', $item_category)
                ->first();

            if ($product) {
                $product->decrement('stock', $quantity);
            }
        }

        return redirect()->route('sale-receipt', [
            'id' => $sale->id,
            'previous_balance' => $previousBalance,
            'closing_balance' => $closingBalance,
            'net_total' => $netTotal
        ])->with('success', 'Sale recorded successfully.');
    }

    // public function store_Sale(Request $request)
    // {
    //     $invoiceNo = Sale::generateInvoiceNo();
    //     \Log::info('Request Data:', $request->all());

    //     $discount = (float)($request->input('discount', 0));
    //     $totalPrice = (float)$request->input('total_price', 0);
    //     $cashReceived = (float)$request->input('cash_received', 0);
    //     $changeToReturn = (float)$request->input('change_to_return', 0);

    //     \Log::info('Processed Values:', [
    //         'discount' => $discount,
    //         'total_price' => $totalPrice,
    //         'cash_received' => $cashReceived,
    //         'change_to_return' => $changeToReturn,
    //     ]);

    //     $usertype = Auth()->user()->usertype;
    //     $userId = Auth::id();

    //     $itemNames = $request->input('item_name', []);
    //     $itemCategories = $request->input('item_category', []);
    //     $quantities = $request->input('quantity', []);

    //     // Step 1: Validate stock for all products
    //     foreach ($itemNames as $key => $item_name) {
    //         $item_category = $itemCategories[$key] ?? '';
    //         $quantity = $quantities[$key] ?? 0;

    //         $product = Product::where('product_name', $item_name)
    //             ->where('category', $item_category)
    //             ->first();

    //         if (!$product) {
    //             return redirect()->back()->with('error', "Product $item_name in category $item_category not found.");
    //         }

    //         if ($product->stock < $quantity) {
    //             return redirect()->back()->with('error', "Insufficient stock for product $item_name. Available: {$product->stock}, Required: $quantity.");
    //         }
    //     }

    //     $customerInfo = explode('|', $request->input('customer_info'));
    //     if (count($customerInfo) < 2) {
    //         return redirect()->back()->with('error', 'Invalid customer information format.');
    //     }

    //     $customerId = $customerInfo[0];
    //     $customerName = $customerInfo[1];

    //     $netTotal = $totalPrice - $discount;

    //     $customerCredit = CustomerCredit::where('customerId', $customerId)->first();

    //     $previousBalance = $customerCredit ? $customerCredit->closing_balance : 0;
    //     $closingBalance = $previousBalance + $netTotal;

    //     if ($cashReceived > 0) {
    //         $closingBalance -= $cashReceived; // Deduct cash received from the closing balance
    //     }

    //     if ($customerCredit) {
    //         $customerCredit->net_total = $netTotal;
    //         $customerCredit->closing_balance = $closingBalance;
    //         $customerCredit->previous_balance = $previousBalance;
    //         $customerCredit->save();
    //     } else {
    //         CustomerCredit::create([
    //             'customerId' => $customerId,
    //             'customer_name' => $customerName,
    //             'previous_balance' => $previousBalance,
    //             'net_total' => $netTotal,
    //             'closing_balance' => $closingBalance,
    //         ]);
    //     }

    //     $saleData = [
    //         'userid' => $userId,
    //         'user_type' => $usertype,
    //         'invoice_no' => $invoiceNo,
    //         'customerId' => $customerId,
    //         'customer' => $customerName,
    //         'sale_date' => $request->input('sale_date', ''),
    //         'warehouse_id' => $request->input('warehouse_id', ''),
    //         'item_category' => json_encode($request->input('item_category', [])),
    //         'item_name' => json_encode($request->input('item_name', [])),
    //         'quantity' => json_encode($request->input('quantity', [])),
    //         'price' => json_encode($request->input('price', [])),
    //         'total' => json_encode($request->input('total', [])),
    //         'note' => $request->input('note', ''),
    //         'total_price' => $totalPrice,
    //         'discount' => $discount,
    //         'Payable_amount' => $netTotal,
    //         'cash_received' => $cashReceived,
    //         'change_return' => $changeToReturn,
    //     ];

    //     $sale = Sale::create($saleData);

    //     foreach ($itemNames as $key => $item_name) {
    //         $item_category = $itemCategories[$key] ?? '';
    //         $quantity = $quantities[$key] ?? 0;

    //         $product = Product::where('product_name', $item_name)
    //             ->where('category', $item_category)
    //             ->first();

    //         if ($product) {
    //             $product->stock -= $quantity;
    //             $product->save();
    //         }
    //     }

    //     return redirect()->route('sale-receipt', [
    //         'id' => $sale->id,
    //         'previous_balance' => $previousBalance,
    //         'closing_balance' => $closingBalance,
    //         'net_total' => $netTotal,
    //     ])->with('success', 'Sale recorded successfully. Redirecting to receipt...');
    // }

    public function all_sales()
    {

        if (Auth::id()) {
            $userId = Auth::id();
            $usertype = Auth()->user()->usertype;

            // Retrieve all Sales with their related Purchase data (including invoice_no)
            $Sales = Sale::where('userid', $userId)->where('user_type', $usertype)->get();
            // dd($Sales);
            return view('admin_panel.sale.all_sales', [
                'Sales' => $Sales,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function get_customer_amount($id)
    {
        // Fetch the customer by customer_id (not id)
        $customer = CustomerCredit::where('customerId', $id)->first();

        // Check if the customer record is found
        if (!$customer) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        // Return the previous amount as JSON
        return response()->json([
            'previous_balance' => $customer->previous_balance // Ensure this field exists in your model
        ]);
    }


        public function downloadInvoice($id)
    {
        // Step 1: Confirm Sale record exists
        $sale = Sale::find($id);
        if (!$sale) {
            abort(404, 'Sale not found with ID: ' . $id);
        }

        // Step 2: Show sale details
        // dd($sale); // Stop here and test

        // Step 3: Match the right customer column name
        $customer = Customer::where('name', $sale->customer)->first();

        if (!$customer) {
            abort(404, 'Customer not found for this sale.');
        }

        // Step 4: Load and return PDF
        $pdf = Pdf::loadView('admin_panel.invoices.invoice', [
            'sale' => $sale,
            'customer' => $customer
        ]);

        return $pdf->download('invoice-' . $sale->invoice_no . '.pdf');
    }

    public function showReceipt(Request $request, $id)
    {
        // dd($request);
        // Fetch the sale data using the sale ID
        $sale = Sale::findOrFail($id);
        // dd($sale);
        // Get customer credit details
        $customerCredit = CustomerCredit::where('customerId', $sale->customerId)->latest()->first();
        // dd($sale->customerId);

        // dd($customerCredit);
        // Initialize variables for previous and closing balance
        $previous_balance = $customerCredit->previous_balance; // Get previous balance from customerCredit
        $closing_balance = $customerCredit->closing_balance;
        // Pass sale data to the receipt view
        return view('admin_panel.sale.receipt', compact('sale', 'customerCredit', 'previous_balance', 'closing_balance'));
    }
}
