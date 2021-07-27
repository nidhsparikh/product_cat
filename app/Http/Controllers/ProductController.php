<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // Validate the max number of characters to avoid database truncation
            'name' => ['required', 'string', 'max:250'],
            'description' => ['required', 'string'],
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // The user should select at least one category
            'categories_id' => ['required', 'array', 'min:1'],
            'categories_id.*' => ['required', 'integer', 'exists:category,id'],
        ]);

        $products = new Product();
        $products->name = $request->name;
        $products->description = $request->description;
        $products->price = $request->price;
        // $products->image = $request->image;
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $products['image'] = "$profileImage";
        }
        $products->save();
        $products->category()->attach($request->categories_id);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        foreach ($product->category as $procat) {
            $selectedTags[] = $procat->id;
        }
        if ($product) {
            return view('product.edit', compact('product', 'categories', 'selectedTags'));
        } else {
            return back()->with('error', 'Data not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        foreach ($product->category as $procat) {
            $selectedTags[] = $procat->id;
        }
        if ($product) {
            $this->validate($request, [
                // Validate the max number of characters to avoid database truncation
                'name' => ['required', 'string', 'max:250'],
                'description' => ['required', 'string'],
                'price' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // The user should select at least one category
                'categories_id' => ['required', 'array', 'min:1'],
                'categories_id.*' => ['required', 'integer', 'exists:category,id'],
            ]);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            // $product->image = $request->image;
            if ($image = $request->file('image')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $product['image'] = "$profileImage";
            } else {
                unset($product['image']);
            }
            $product->save();
            Product::find($id)->category()->sync($request->categories_id);
            // $product->category()->attach($request->categories_id);
            
            return redirect()->route('product.index');
        } else {
            return back()->with('error', 'Data not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $status = $product->delete();
            $product->category()->detach();
            return redirect()->route('product.index')->with('success', 'Category successfully deleted.');
        } else {
            return back()->with('error', 'Data not found.');
        }
    }
}
