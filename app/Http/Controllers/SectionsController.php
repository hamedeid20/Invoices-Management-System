<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Sections::all();
        return view('sections.sections', compact('sections'));
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
            'section_name' => 'required|unique:sections|max:255',
        ], [
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'القسم مسجل مسبقا',
        ]);

        $data = $request->only('section_name', 'description');


        sections::create([
            'section_name' => $data['section_name'],
            'description' => $data['description'],
            'created_by' => (Auth::user()->name)
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect('/sections');


        // طريقة اخرى
        // $data = $request->only('section_name', 'description');

        // $data_exists = sections::where('section_name', '=', $data['section_name'])->exists();

        // if($data_exists){
        //     session()->flash('Error', 'خطأ القسم مسجل مسبقا');
        //     return redirect('/sections');
        // }else{
        //     sections::create([
        //         'section_name' => $data['section_name'],
        //         'description' => $data['description'],
        //         'created_by' => (Auth::user()->name)
        //     ]);

        //     session()->flash('Add', 'تم اضافة القسم بنجاح');
        //     return redirect('/sections');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        
        $val = $request->validate([
            // انا بستثنى عملية التحقق الصف اللى انا بعته فى الطلب 
            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('Edit', 'تم تعديل القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, sections $sections)
    {
        $id = $request->id;
        $sections::find($id)->delete();
        session()->flash('Delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');
        
    }
}
