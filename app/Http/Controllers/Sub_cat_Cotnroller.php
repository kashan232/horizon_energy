<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Sub_cat_Cotnroller extends Controller
{
    public function sub_category()
    {
        // dd("ad");
        if (Auth::id()) {
            $userId = Auth::id();
            $all_sub_categories = Subcategory::with('category')->get();
            // dd($all_sub_categories->toArray());
            $categories = Category::get();
    
            return view('admin_panel.sub_category.sub_category',compact('all_sub_categories', 'categories'));
        } else {
            return redirect()->back();
        }
    }
    
    public function store_sub_category(Request $request)
    {
        // dd($request->toArray());
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Subcategory::create([
                'category_id' => $request->category_id,
                'name' => $request->sub_category
            ]);
            return redirect()->back()->with('success', 'Sub Category Added Successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_sub_category(Request $request)
    {
        // dd($request->toArray());
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($reques   t);
            // $update_id = $request->input('category_id');
            // $category = $request->input('category_name');

            Subcategory::where('id', $request->sub_cat_id)->update([
                'category_id'   => $request->category_id,
                'name' => $request->sub_category,
            ]);
            return redirect()->back()->with('success', 'Sub Category Updated Successfully');
        } else {
            return redirect()->back();
        }
    }
}
