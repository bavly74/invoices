<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import the DB facade

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=Section::all();
        return view('sections.index',['sections'=>$sections]);
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
        //First way of validation :

        // if (Section::where('section_name', '=', $request->section)->exists()) {
        //     return redirect()->back()->with('error', 'Section already exists.');

        //  }
        //  else{

        //     $request->validate([
        //         'section'=>'required'


        //     ]);

        //     DB::table('sections')->insert([

        //             'section_name' =>$request->section,
        //             'description'=>$request->description,
        //             'created_by'=>Auth::user()->name

        //         ]
        //     );

        //     return redirect()->back()->with('success', 'Section added successfully.');


        //  }


        //2nd way of validation :
        $request->validate([
            'section_name'=>'required|unique:sections',
            'description'=>'required'

        ],

        [
            'section_name.required'=>'يرجي ادخال القسم',
            'section_name.unique'=>'القسم موجود مسبقا',
            'description.required'=>'يرجي ادخال الوصف'
        ]

    );

    DB::table('sections')->insert([

                    'section_name' =>$request->section_name,
                    'description'=>$request->description,
                    'created_by'=>Auth::user()->name

    ]);

    return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success','تم تعديل البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $sections = Section::find($id);
        $sections->delete();
        return redirect()->back()->with('success','تم حذف البيانات بنجاح');

    }
}
