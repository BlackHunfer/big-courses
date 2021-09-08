<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Course;
use App\Models\Theme;
use App\Models\Material;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teacher = $request->user();

        if(isset($teacher->speciality_id)){
            $courses = Course::where("speciality_id", $teacher->speciality_id)
                ->orderBy('id', 'asc')
                ->get();
        }else{
            if($request->user()->hasRole('teacher')){
                $admin_id = $teacher->teacher_admins[0]->id;
                $admin = User::find($admin_id);
            }
            if($request->user()->hasRole('administrator')){
                $admin = Auth::user();
            }
            $courses = $admin->admin_courses()
                ->where("speciality_id", null)
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('teacher.course_index', [
            'courses' => $courses,
        ]);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('courses.index')
              ->withInput()
              ->withErrors($validator);
        }

        $teacher = $request->user();
        $admin_id = $teacher->teacher_admins[0]->id;

        $courseNew = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'admin_id' => $admin_id,
            'speciality_id' => $teacher->speciality_id ? $teacher->speciality_id : null,
            'created_by' => Auth::user()->id,
        ]);

        Session::flash('message', 'Курс успешно создан!');

        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {

        $themes = $course->themes()
            ->whereNull('theme_id')
            ->with('childrenThemes')
            ->orderBy('id', 'asc')// поменять на order
            ->get();
        
        // $themesChild = $course->themes()
        //     ->with('childrenThemes')
        //     ->orderBy('id', 'asc')// поменять на order
        //     ->get();

        return view('teacher.course_edit', [
            'course' => $course,
            'themes' => $themes,
            // 'themesChild' => $themesChild,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
