<?php
// app/Http/Controllers/SupplierPaymentController.php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        // Fetch payments with associated suppliers
        $payments = SupplierPayment::with('supplier')->latest()->paginate(10);
    
        // Fetch all suppliers to pass to the view
        $suppliers = Supplier::all();
    
        // Return the view and pass both payments and suppliers
        return view('admin_panel.supplier_payments.index', compact('payments', 'suppliers'));
    }
    

    public function create()
    {
        $suppliers = Supplier::all();
        return view('admin_panel.supplier_payments.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:payable,receivable',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        SupplierPayment::create($request->all());

        return redirect()->route('supplier-payments.index')
            ->with('success', 'Payment Recorded Successfully!');
    }

    public function edit(SupplierPayment $supplierPayment)
    {
        $suppliers = Supplier::all();
        return view('supplier_payments.edit', compact('supplierPayment', 'suppliers'));
    }

    public function update(Request $request, SupplierPayment $supplierPayment)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:payable,receivable',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $supplierPayment->update($request->all());

        return redirect()->route('supplier-payments.index')
            ->with('success', 'Payment Updated Successfully!');
    }

    public function destroy(SupplierPayment $supplierPayment)
    {
        $supplierPayment->delete();
        return redirect()->route('supplier-payments.index')
            ->with('success', 'Payment Deleted Successfully!');
    }
}

