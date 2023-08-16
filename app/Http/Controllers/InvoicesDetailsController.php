<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Auth; // Import the DB facade

use App\Models\InvoicesDetails;
use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\InvoicesAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        $details = InvoicesDetails::where('invoice_id', $id)->get();
        $attachments=InvoicesAttachments::where('invoice_id',$id)->get();
        return view('invoices.invoiceDetails',['invoices'=>$invoices,'details'=>$details,'attachments'=>$attachments]);
    }



    public function openFile($file_name)
{
    $file_path = public_path($file_name);

    if (file_exists($file_path)) {
        return response()->file($file_path);
    } else {
        return 'File not found';
    }
}


public function destroy(Request $request)
{
    $invoices = InvoicesAttachments::findOrFail($request->id_file);
    $invoices->delete();
    Storage::disk('bavly')->delete('attachments/'.$request->file_name);
    session()->flash('delete', 'تم حذف المرفق بنجاح');
    return back();
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
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */

}
