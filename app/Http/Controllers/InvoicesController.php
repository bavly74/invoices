<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Auth; // Import the DB facade
use App\Models\Invoices;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=Invoices::all();
        return view('invoices.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getproducts($id)
     {
         $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
         return json_encode($products);
     }

    public function create()
    {
        $sections=Section::all();
        $products=Product::all();
        return view('invoices.create',['sections'=>$sections,'products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //inputs validations
        $request->validate([
            'invoice_number'=>'required',
            'invoice_Date'=>'required',
            'Due_date'=>'required',
            'Section'=>'required',
            'Amount_collection'=>'required',
            'Amount_Commission'=>'required',
            'Discount'=>'required',
            'Rate_VAT'=>'required',
            'Value_VAT'=>'required',
            'pic'=>'required|mimes:jpg,png,jpeg'
        ]);

        //insert in invoices table

        DB::table('invoices')->insert([
            'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'Due_date'=>$request->Due_date,
            'product'=>$request->product,
            'section_id'=>$request->Section,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'Discount'=>$request->Discount,
            'Value_VAT'=>$request->Value_VAT,
            'Rate_VAT'=>$request->Rate_VAT,
            'Total'=>$request->Total,
            'Value_Status'=>2,
            'Status'=> 'غير مدفوع',
            'note'=>$request->note
        ]);

        //insert in invoices_details table

        $invoice_id=Invoices::latest()->first()->id;

        DB::table('invoices_details')->insert([
            'invoice_number'=>$request->invoice_number,
            'invoice_id'=>$invoice_id,
            'product'=>$request->product,
            'Section'=>$request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);


        //insert in invoices_attachments table
        if($request->hasFile('pic')){
            $image=$request->file('pic')->getClientOriginalName();
        $path=$request->file('pic')->storeAs('invoices',$image,'bavly');

        DB::table('invoices_attachments')->insert([
            'file_name'=>$path,
            'invoice_number'=>$request->invoice_number,
            'Created_by'=>(Auth::user()->name),
            'invoice_id'=>$invoice_id
        ]);
        }

        return redirect()->back()->with('success','تم اضافة الفاتورة بنجاح');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $invoice=Invoices::findOrFail($id);
       $sections=Section::all();
       return view('invoices.edit',['invoice'=>$invoice,'sections'=>$sections]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::table('invoices')->where('id',$request->invoice_id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Invoices::where('id',$id)->delete();
       session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
       return back();
    }
}
