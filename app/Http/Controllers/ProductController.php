<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function all_product()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = Product::get();
            return view('admin_panel.product.all_product', [
                // 'all_unit' => $all_unit
                'all_product' => $all_product,
            ]);
        } else {
            return redirect()->back();
        }
    }
    public function add_product()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_category = Category::where('admin_or_user_id', '=', $userId)->get();
            $all_brand = Brand::where('admin_or_user_id', '=', $userId)->get();
            $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();

            return view('admin_panel.product.add_product', [
                'all_category' => $all_category,
                'all_brand' => $all_brand,
                'all_unit' => $all_unit,

            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getSubcategories($category)
    {
        $subcategories = SubCategory::where('category_id', $category)->get();
        return response()->json($subcategories);
    }
    public function getItems($category, $subcategory)
    {
        $items = Product::where('category_id', $category)
            ->where('subcategory_id', $subcategory)
            ->with('unit:id,unit') // Yeh ensure karega ke sirf unit ka name aaye
            ->get(['id', 'name', 'unit_id', 'price']);

        // Data modify karke response bhejna
        $items = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'unit' => $item->unit ? $item->unit->unit : '', // Agar unit available hai toh name le lo
                'price' => $item->price,
            ];
        });

        return response()->json($items);
    }



    public function store_product(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();

            // Handle image upload if provided
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product_images'), $imageName);
            }

            // Create product
            Product::create([
                'name'          => $request->product_name,
                'category_id'   => $request->category,
                'subcategory_id' => $request->sub_category,
                'unit_id'       => $request->unit,
                'price'         => $request->retail_price,
                'wholesale_price'         => $request->wholesale_price,
                'image'         => $imageName,
                'alert_quantity' => $request->alert_quantity,
                'note'            => $request->note,
                'brand'            => $request->brand,
                'stock'            => $request->stock,

            ]);

            return redirect()->back()->with('success', 'Product Added Successfully');
        }

        return redirect()->back();
    }

    public function edit_product($id)
    {

        if (Auth::id()) {
            $userId = Auth::id();
            $all_category = Category::where('admin_or_user_id', '=', $userId)->get();
            $all_brand = Brand::where('admin_or_user_id', '=', $userId)->get();
            $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $product_details = Product::findOrFail($id);
            // dd($product_details);
            return view('admin_panel.product.edit_product', [
                'all_category' => $all_category,
                'all_brand' => $all_brand,
                'all_unit' => $all_unit,
                'product_details' => $product_details,

            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update_product(Request $request, $id)
    {
        if (Auth::id()) {
            $userId = Auth::id();

            // Validate the incoming request
            $request->validate([
                'product_name'    => 'required|string|max:255',
                'category'        => 'required|integer|exists:categories,id',
                'brand'           => 'required|string|max:255',
                'sku'             => 'required|string|max:255',
                'unit'            => 'required|integer|exists:units,id',
                'alert_quantity'  => 'required|integer',
                'price'           => 'nullable|numeric',
                'note'            => 'nullable|string',
                'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // Validate image upload
            ]);

            // Find the product by ID
            $product = Product::findOrFail($id);

            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($product->image) {
                    $oldImagePath = public_path('product_images/' . $product->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product_images'), $imageName);

                // Set the new image name in the product data
                $product->image = $imageName;
            }

            // Update product details
            $product->name             = $request->product_name;
            $product->category_id      = $request->category;
            $product->brand            = $request->brand;
            $product->sku              = $request->sku;
            $product->unit_id          = $request->unit;
            $product->alert_quantity   = $request->alert_quantity;
            $product->price            = $request->price;
            $product->note             = $request->note;
            $product->updated_at       = Carbon::now();

            // Save updated product
            $product->save();

            return redirect()->route('all-product')->with('success', 'Product updated successfully');
        } else {
            return redirect()->back();
        }
    }

    public function getProductDetails($productName)
    {
        $product = Product::where('product_name', $productName)->first();
        if ($product) {
            return response()->json([
                'retail_price' => $product->retail_price,
                'stock' => $product->stock,
            ]);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q');

        // Perform a search based on the product name
        $products = Product::where('product_name', 'like', '%' . $query . '%')
            ->get(['id', 'category', 'product_name', 'retail_price']);

        return response()->json($products);
    }

    public function product_alerts()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $lowStockProducts = Product::whereRaw('CAST(stock AS UNSIGNED) <= CAST(alert_quantity AS UNSIGNED)')->get();
            // dd($lowStockProducts);
            return view('admin_panel.product.product_alerts', [
                'lowStockProducts' => $lowStockProducts,
            ]);
        } else {
            return redirect()->back();
        }
    }
}
