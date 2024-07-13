<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.invoices_archive', compact('invoices'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $restore_invoice = isset($request->restore_archive) ? $request->restore_archive : null;

        if ($restore_invoice == 1) {
            Invoices::withTrashed()->where('id', $invoice_id)->restore();
            session()->flash('Restore_Archive', ' تم استعادة الفاتورة بنجاح');
            return redirect('/archive');
        } else {
            $invoice = Invoices::withTrashed()->where('id', $invoice_id);

            $attachment = invoice_attachments::where('invoice_id', $invoice_id)->first();

            if (!empty($attachment->invoice_number)) {
                Storage::disk('public_uploads')->deleteDirectory(DIRECTORY_SEPARATOR . $attachment->invoice_number);
            }

            $invoice->forceDelete();
            session()->flash('Delete', 'تم حذف الفاتورة بنجاح');
            return redirect('/archive');
        }
    }
}
