<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = Products::all();
        return view('products.products', compact('sections', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $val = $request->validate([
            'product_name' => 'required',
            'section_id' => 'required',

        ],[
            'product_name.required' => 'يجب ادخال اسم المنتج',
            'section_id.required' => 'يجب تحديد القسم'
        ]);

        $product = Products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);

        if($product){
            session()->flash('Add', 'تم اضافة المنتج بنجاح');
        }

        return redirect('/products');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $val = $request->validate([
            'id' => 'required',
            'product_name' => 'required',
            'section_id' => 'required'
        ],[
            'id.required' => 'من فضلك اعد تحميل الصفحة ، وحاول مرا اخرى',
            'product_name.required' => 'يجب ادخال اسم المنتج',
            'section_id.required' => 'يجب تحديد قسم'
        ]);

        $id = $request->id;
        $product = Products::find($id);

        if(!$product){
            session()->flash('Error', 'المنتج غيرموجود');
        }

        $product->update([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);

        if($product){
            session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        }

        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $product = Products::find($id);

        if(!$product){
            session()->flash('Error', 'لا يوجد منتج بهذا الاسم');
            return redirect('/products');
        }
        
        $product->delete();
        session()->flash('Delete', 'تم حذف المنتج بنجاح');
        return redirect('/products');

    }
}
