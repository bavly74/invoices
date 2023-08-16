<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Import the DB facade
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Section;
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
        $products=Product::all();
        $sections=Section::all();
        return view('products.index',['products'=>$products,'sections'=>$sections]);
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
        $request->validate([
            'product_name'=>'required|unique:products',
            'description'=>'required'
        ],

        [
            'product_name.required'=>'يرجي ادخال اسم المنتج',
            'product_name.unique'=>'هذا المنتج موجود مسبقا',
            'description.required'=>'يرجي ادخال القسم'

        ]

    );

    DB::table('products')->insert([
        'product_name'=>$request->product_name,
        'section_id'=>$request->section_id,
        'description'=>$request->description
    ]);
    return redirect()->back()->with('success','تم اضافة المنتج بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->id;




        $this->validate($request, [

            'product_name' => 'required|max:255|unique:products,product_name,'.$id,
            'description' => 'required',
        ],[

            'product_name.required' =>'يرجي ادخال اسم المنتج',
            'product_name.unique' =>'اسم المنتج مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        //OR//

    //     $request->validate([
    //         'product_name'=>'required|unique:products'.$id,
    //         'description'=>'required'
    //     ],

    //     [
    //         'product_name.required'=>'يرجي ادخال اسم المنتج',
    //         'product_name.unique'=>'هذا المنتج موجود مسبقا',
    //         'description.required'=>'يرجي ادخال القسم'

    //     ]
    // );



        DB::table('products')->where('id',$id)->update([
            'product_name'=>$request->product_name,
            'section_id'=>$request->section_id,
            'description'=>$request->description
        ]);
        return redirect()->back()->with('success','تم تعديل البيانات بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        DB::table('products')->where('id',$id)->delete();
        return redirect()->back()->with('success','تم حذف المنتج بنجاح');




    }
}
