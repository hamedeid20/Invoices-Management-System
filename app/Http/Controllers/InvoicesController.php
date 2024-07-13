<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\invoice_attachments;
use App\Models\Invoices;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\Add_Invoice;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        $invoice_id = Invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        if($request->hasFile('pic')){

            $invoice_id = Invoices::latest()->first()->id;
            $file = $request->file('pic');
            $file_name = $file->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            $created_by = Auth::user()->name;

            $attachment = new invoice_attachments();

            $attachment->file_name = $file_name;
            $attachment->invoice_number = $invoice_number;
            $attachment->created_by = $created_by;
            $attachment->invoice_id = $invoice_id;

            $attachment->save();
            
            $file_name = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $file_name);
        }


        // $user = User::first();
        // $invoices = invoices::latest()->first();
        // Notification::send($user, new AddInvoice($invoices));


        $user = User::get(); // send to all users
        // $user = User::find(Auth::user()->id); // send for me only
        $invoices = Invoices::latest()->first();
        Notification::send($user, new Add_Invoice($invoices));


        session()->flash('Add', 'تم حفظ الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoices::where('id', $id)->first();
        return view('invoices.update_status_invoice', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.update_invoice', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoices::findOrFail($id);
        
        $invoice->update([
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);

        session()->flash('Update', 'تم تعديل الفاتورة بنجاح');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $is_archive = $request->archive;

        $invoice = Invoices::where('id', $id)->first();

        if(isset($is_archive) && $is_archive == 1){
            $invoice->delete();
            session()->flash('Archive', 'تم نقل الفاتورة الى الارشيف بنجاح');
            return redirect('/invoices');
        }else{
            // $attachment = invoice_attachments::where('invoice_id', $id)->get();
            $attachment = invoice_attachments::where('invoice_id', $id)->first();

            // foreach($attachment as $item){
                // echo $item;
                if(!empty($attachment->invoice_number)){
                    // Storage::disk('public_uploads')->delete(DIRECTORY_SEPARATOR . $item->invoice_number. DIRECTORY_SEPARATOR . $item->file_name);
                    Storage::disk('public_uploads')->deleteDirectory(DIRECTORY_SEPARATOR . $attachment->invoice_number);
                }
            // }

            $invoice->forceDelete();
            session()->flash('Delete', 'تم حذف الفاتورة بنجاح');
            return redirect('/invoices');
        }



    }

    public function getProducts($id){
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function status_update(Request $request, $id){
        $invoice = Invoices::findOrFail($id);

        if($request->payment_status === "مدفوعة"){
            $invoice->update([
                'value_status' => 1,
                'status' => $request->payment_status,
            ]);
            invoices_details::create([
            'id_Invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => $request->payment_status,
            'value_status' => 1,
            'note' => $request->note,
            'payment_date' => $request->payment_date,
            'user' => Auth::user()->name,
            ]);
        }else{
            $invoice->update([
                'value_status' => 3,
                'status' => $request->payment_status,
            ]);
            invoices_details::create([
            'id_Invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => $request->payment_status,
            'value_status' => 3,
            'note' => $request->note,
            'payment_date' => $request->payment_date,
            'user' => Auth::user()->name,
            ]);
        }

        session()->flash('Status_Update', 'تم تحديث حالة الدفع بنجاح');
        return redirect('/invoices');
    }

    public function invoice_paid(){
        $invoices = Invoices::where('value_status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function invoice_unpaid(){
        $invoices = Invoices::where('value_status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }
    public function invoice_partial(){
        $invoices = Invoices::where('value_status', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }

    public function invoice_print($id){
        $invoices = Invoices::where('id', $id)->first();
        // dd($invoices);
        return view('invoices.invoice_print', compact('invoices'));
    }
    public function export() 
    {
        return Excel::download(new InvoicesExport, 'Invoices.xlsx');
    }

    public function MarkAsRead_all(Request $request){

        $userUnreadNotification = Auth::user()->unreadNotifications;

        if($userUnreadNotification){

            $userUnreadNotification->markAsRead();
            return back();
        }

    }
}
