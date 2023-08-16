<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Auth; // Import the DB facade

use App\Models\InvoicesAttachments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function addAttachment(Request $request){

        $request->validate([
            'file_name'=>'mimes:jpg,png,jpeg'
        ],
    [
        'file_name.mimes'=>' يرجي ادخال مرفق صحيح'
    ]);

    $image=$request->file('file_name')->getClientOriginalName();
    $path=$request->file('file_name')->storeAs('invoices',$image,'bavly');
    DB::table('invoices_attachments')->insert([
        'file_name'=>$path,
        'invoice_number'=>$request->invoice_number,
        'Created_by'=>(Auth::user()->name),
        'invoice_id'=>$request->invoice_id
    ]);
      session()->flash('add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicesAttachments $invoicesAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicesAttachments $invoicesAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicesAttachments $invoicesAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicesAttachments $invoicesAttachments)
    {
        //
    }
}
