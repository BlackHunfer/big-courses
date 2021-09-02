<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Material;
use App\Models\Course;
use App\Models\Theme;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Course $course, Theme $theme, $material_type_id)
    {

        $material_type = Helper::typeMaterialIdToStr($material_type_id);

        return view('teacher.material_create', [
            'course' => $course,
            'theme' => $theme,
            'material_type' => $material_type,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, Theme $theme, $material_type_id)
    {
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('courses.index')
        //       ->withInput()
        //       ->withErrors($validator);
        // }

        $teacher = $request->user();

        $materialNew = Material::create([
            'title' => $request->title,
            'text' => $request->text,
            'course_id' => $course->id,
            'theme_id' => $theme->id,
            'material_type_id' => $material_type_id,
            'material_open_id' => '2',
            'order' => '1',
            'created_by' => $request->user()->id,
        ]);

        Session::flash('message', 'Материал успешно создан!');

        return redirect()->route('courses.edit', ['course' => $course->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Material $material)
    {

        return view('teacher.material_edit', [
            // 'course' => $course,
            'material' => $material,
            // 'themesChild' => $themesChild,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
}
