<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\Invoices;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $is_archive = null)
    {
        // $invoice = Invoices::find($id);
        if(isset($is_archive) && $is_archive == 1){
            $invoice = Invoices::withTrashed()->where('id', $id)->first();
        }else{
            $invoice = Invoices::where('id', $id)->first();
        }

        $invoice_details = invoices_details::where('id_Invoice', $id)->get();
        $invoice_attachments = invoice_attachments::where('invoice_id', $id)->get();

        // echo " ID ::: " . $id . "<br>" . "Ar : " . $is_archive;
        // return $invoice;
        // dd($invoice);


        return view('invoices.details_invoice', compact(['invoice', 'invoice_details', 'invoice_attachments']));
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
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $file_attachment = invoice_attachments::findOrFail($request->id_file);
        $file_attachment->delete();
        Storage::disk('public_uploads')->delete(DIRECTORY_SEPARATOR . $request->invoice_number. DIRECTORY_SEPARATOR . $request->file_name);
        session()->flash('Delete', 'تم حذف المرفق بنجاح');
        return back();
        // dd($request);

    }

    public function open_file($invoice_number, $file_name){
        // $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number. '/' . $file_name);

        $files = public_path('Attachments'. DIRECTORY_SEPARATOR . $invoice_number. DIRECTORY_SEPARATOR . $file_name);
        
        return response()->file($files);
        // echo($files);
    }

    public function download_file($invoice_number , $file_name){

        $file = public_path('Attachments'. DIRECTORY_SEPARATOR . $invoice_number. DIRECTORY_SEPARATOR . $file_name);
        return response()->download($file);
    }
}
