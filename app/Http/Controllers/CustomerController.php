<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SocialCustomer ;
use App\Models\CustomerCredit;
use App\Models\CustomerRecovery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function customer()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId); 
            $Customers = Customer::get();
            return view('admin_panel.customers.customers', [
                'Customers' => $Customers
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_customer(Request $request)
    {
        // dd($request->toArray());
        $lastCustomer = Customer::latest('id')->first(); // Last customer ka ID find karega
        $nextId = $lastCustomer ? $lastCustomer->id + 1 : 1; // Agar koi customer nahi mila toh 1 set karega
        
        // dd('CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT));
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Customer::create([
                'name'          => $request->customer_name,
                'email'          => $request->customer_email,
                'phone'          => $request->customer_phone,
                'address'          => $request->customer_address,
                'identity'          => 'CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
            ]);
            return redirect()->back()->with('success', 'Customer has been  created successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_customer(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($request);
            $update_id = $request->input('customer_id');
            $name = $request->input('customer_name');
            $email = $request->input('customer_email');
            $phone = $request->input('customer_phone');
            $address = $request->input('customer_address');

            Customer::where('id', $update_id)->update([
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

    public function processRecovery(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'recovery_date' => 'required|date',
            'recovery_amount' => 'required|numeric|min:0',
        ]);

        $customer_id = $request->customer_id;

        // Fetch the customer record (use first() to get a single record)
        $customer = CustomerCredit::where('customerId', $customer_id)->first();

        // Check if the customer record exists
        if (!$customer) {
            return redirect()->back()->withErrors(['customer_id' => 'Customer credit record not found!']);
        }

        // Calculate new balances
        $recoveryAmount = $request->recovery_amount;
        $updatedClosingBalance = $customer->closing_balance - $recoveryAmount;

        // Store recovery details in the CustomerRecovery table
        CustomerRecovery::create([
            'customer_id' => $customer->customerId, // Use customerId instead of id for CustomerCredit
            'customer_name' => $customer->customer_name,
            'recovery_date' => $request->recovery_date,
            'recovery_amount' => $recoveryAmount,
            'closing_balance' => $updatedClosingBalance,
        ]);

        // Update customer's balance in the CustomerCredit table
        $customer->previous_balance -= $recoveryAmount;
        $customer->closing_balance = $updatedClosingBalance;
        $customer->save();

        return redirect()->back()->with('success', 'Customer recovery details saved successfully!');
    }

    public function customer_recovires()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            // Fetch customers along with their closing balance from customer_credits
            $Customers = CustomerRecovery::get();

            return view('admin_panel.customers.customers_recoveries', [
                'Customers' => $Customers
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function addCredit(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'credit_amount' => 'required|numeric|min:0',
        ]);
        // Get customer credit entry if it exists
        $customerCredit = CustomerCredit::where('customerId', $request->customer_id)->first();

        $creditAmount = $request->credit_amount;
        $customer_name = $request->customer_name;

        if ($customerCredit) {
            // Update the existing entry if customer credit exists
            $customerCredit->previous_balance += $creditAmount;
            $customerCredit->closing_balance += $creditAmount;
            $customerCredit->save();
        } else {
            // Create a new entry if customer credit does not exist
            $customerCredit = CustomerCredit::create([
                'customerId' => $request->customer_id,
                'customer_name' => $customer_name,
                'previous_balance' => $creditAmount,
                'net_total' => '0',
                'closing_balance' => $creditAmount, // Assuming the balance starts with the credit amount
            ]);
        }

        return redirect()->back()->with('success', 'Credit added successfully to the customer.');
    }
    public function removeFromCart($id)
{
    $cart = session()->get('cart', []);
    unset($cart[$id]);
    session()->put('cart', $cart);

    return redirect()->route('deals.cart')->with('success', 'Item removed from cart');
}


public function social_customer()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId); 
            $SocialCustomer = SocialCustomer::get();
            return view('admin_panel.customers.social_customers', [
                'SocialCustomers' => $SocialCustomer
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function social_store_customer(Request $request)
{
    $lastCustomer = SocialCustomer::latest('id')->first(); // ab SocialCustomer
    $nextId = $lastCustomer ? $lastCustomer->id + 1 : 1;

    if (Auth::id()) {
        $usertype = Auth()->user()->usertype;
        $userId = Auth::id();
        SocialCustomer::create([
            'name'          => $request->customer_name,
            'email'         => $request->customer_email,
            'phone'         => $request->customer_phone,
            'address'       => $request->customer_address,
            'system_size'   => $request->system_size,
            'identity'      => 'CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
        ]);
        return redirect()->back()->with('success', 'Customer has been created successfully');
    } else {
        return redirect()->back();
    }
}


public function social_update_customer(Request $request)
{
    if (Auth::id()) {
        $usertype = Auth()->user()->usertype;
        $userId = Auth::id();

        $update_id = $request->input('customer_id');
        $name = $request->input('customer_name');
        $email = $request->input('customer_email');
        $phone = $request->input('customer_phone');
        $address = $request->input('customer_address');
        $system_size = $request->input('system_size');

        SocialCustomer::where('id', $update_id)->update([
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'address'       => $address,
            'system_size'   => $system_size,
            'updated_at'    => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Customer Updated Successfully');
    } else {
        return redirect()->back();
    }
}
public function confirm_social_customer($id)
{
    $socialCustomer = SocialCustomer::find($id);

    if (!$socialCustomer) {
        return redirect()->back()->with('error', 'Customer not found.');
    }

    // Generate new identity for Customer
    $lastCustomer = Customer::latest('id')->first();
    $nextId = $lastCustomer ? $lastCustomer->id + 1 : 1;
    $newIdentity = 'CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    Customer::create([
        'name'      => $socialCustomer->name,
        'phone'     => $socialCustomer->phone,
        'email'     => $socialCustomer->email,
        'address'   => $socialCustomer->address,
        'identity'  => $newIdentity, // 👈 NEW generated identity
    ]);

    $socialCustomer->update([
        'confirmed' => true
    ]);

    return redirect()->back()->with('success', 'Customer confirmed successfully.');
}


 
}
