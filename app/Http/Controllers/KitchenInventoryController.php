<?php

namespace App\Http\Controllers;

use App\Models\KitchenInventory;
use App\Models\KitchenItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KitchenInventoryController extends Controller
{
    public function index()
    {
        $kitchenItems = KitchenItem::all(); // Fetch all kitchen items
        $inventoryItems = KitchenInventory::with('item')->get(); // Fetch inventory with related items

        return view('admin_panel.kitchen_inventory.kitchen_inventory', compact('kitchenItems', 'inventoryItems'));
    }


    // Add New Kitchen Item
    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:kitchen_items,name|max:255',
        ]);

        KitchenItem::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Item added successfully!');
    }

    // Add Inventory Item
    public function storeInventory(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:kitchen_items,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        KitchenInventory::create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Inventory updated successfully!');
    }
}
