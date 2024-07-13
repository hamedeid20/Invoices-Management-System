<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index()
    {
        $sections = sections::all();
        return view('reports.customers_report', compact('sections'));
    }
    public function search_customers(Request $request)
    {
        if ($request->section_id && $request->product && $request->start_at == '' && $request->end_at == '') {

            
            $invoices = Invoices::select('*')->where('section_id', '=', $request->section_id)->where('product', '=', $request->product)->get();
            // return $invoices;
            $sections = sections::all();
            return view('reports.customers_report', compact('sections'))->with('details', $invoices);
        }


        // في حالة البحث بتاريخ
        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('section_id', '=', $request->section_id)->where('product', '=', $request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report', compact('sections'))->with('details', $invoices);
        }
    }
}
