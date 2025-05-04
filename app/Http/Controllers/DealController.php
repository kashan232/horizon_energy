<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::latest()->get();
        return view('admin_panel.deal.index', compact('deals'));
    }

    public function create()
    {
        return view('admin_panel.deal.create');
    }
    public function destroy($id)
{
    $deal = Deal::find($id);

    if (!$deal) {
        return redirect()->route('deal.index')->with('error', 'Deal not found!');
    }

    $deal->delete();

    return redirect()->route('deal.index')->with('success', 'Deal deleted successfully!');
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'nullable|image',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('deals', 'public');
        }

        Deal::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'image' => $imagePath,
        ]);

        return redirect()->route('deal.index')->with('success', 'Deal added successfully!');
    }

    public function toggleStatus($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->status = !$deal->status;
        $deal->save();

        return redirect()->back()->with('success', 'Deal status updated successfully!');
    }

    public function webpage()
    {
        $deals = Deal::where('status', true)->get();
        $clientInfo = session('client_info');
        return view('admin_panel.deal.webpage', compact('deals', 'clientInfo'));
    }

    public function show($id)
    {
        $deal = Deal::findOrFail($id);
        return view('admin_panel.deal.show', compact('deal'));
    }

    public function storeClientInfo(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        session(['client_info' => $request->only('name', 'email', 'phone')]);
        session()->put('client_info_submitted', true); 
        return redirect()->route('cart.show')->with('success', 'Client information saved successfully!');
    }

    public function addToCart(Request $request, $id)
    {
        $deal = Deal::findOrFail($id);

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'title' => $deal->title,
                'price' => $deal->price,
                'quantity' => 1,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Deal added to cart!');
    }

    public function showCart()
    {
        $cart = session('cart', []);
        $clientInfo = session('client_info');

        return view('admin_panel.deal.cart', compact('cart', 'clientInfo'));
    }

    public function placeOrder(Request $request)
    {
        // (Future mein yahan database mein order save kar sakte hain)

        session()->forget('cart');
        session()->forget('client_info');

        return redirect()->route('all-deal.public')->with('success', 'Order placed successfully!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
