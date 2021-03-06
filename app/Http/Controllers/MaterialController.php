<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Material;
use App\Models\Course;
use App\Models\Theme;
use App\Models\Result;

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

        $material_type = Helper::typeMaterialIdToStr($material_type_id)['title'];
        $opensMaterialIds = Helper::opensMaterialIds();

        return view('teacher.material_create', [
            'course' => $course,
            'theme' => $theme,
            'material_type_id' => $material_type_id,
            'material_type' => $material_type,
            'opensMaterialIds' => $opensMaterialIds,
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'material_open_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
              ->withInput()
              ->withErrors($validator);
        }

        $teacher = $request->user();

        if($request->text){
            $texts = $request->text;
            $texts = array_diff($texts, [null]);
            $texts = array_values($texts);

            if(empty($texts)){
                $texts = null;
            }
        }else{
            $texts = null;
        }

        //???????????????? ??????????????
        $date_closing_access = null;
        if($request->date_close_days || $request->date_close_days === '0' || $request->date_close_hours || $request->date_close_hours === '0' || $request->date_close_minutes || $request->date_close_minutes === '0'){
            $date_closing_access = [
                [
                    'days' => $request->date_close_days
                ], 
                [
                    'hours' => $request->date_close_hours
                ], 
                [
                    'minutes' => $request->date_close_minutes
                ]
            ];
        }

        $upload_file = null;
        if($request->upload_file){
            $upload_file = [];
            foreach($request->upload_file as $key1 => $file_url){
                foreach($request->upload_file_name as $key2 => $file_name){
                    foreach($request->upload_file_type as $key3 => $file_type){
                        if($key1 == $key2 && $key2 == $key3){
                            array_push($upload_file, ['name' => $file_name, 'url' => $file_url, 'type' => $file_type]);
                        }
                    }
                    
                }
            }
        }


        $materialNew = Material::create([
            'title' => $request->title,
            'text' => $texts,
            'video' => $request->video,
            'upload_file' => $upload_file,
            'course_id' => $course->id,
            'theme_id' => $theme->id,
            'material_type_id' => $material_type_id,
            'material_open_id' => $request->material_open_id,
            'material_id' => $request->material_id ? $request->material_id : null,
            'date_open_days' => $request->date_open_days ? $request->date_open_days : null,
            'date_open_hours' => $request->date_open_hours ? $request->date_open_hours : null,
            'date_open_minutes' => $request->date_open_minutes ? $request->date_open_minutes : null,
            'opens_after_day' => $request->opens_after_day ? Carbon::parse($request->opens_after_day) : null,
            'date_closing_access' => $date_closing_access ? $date_closing_access : null,
            'order' => '1',
            'created_by' => $request->user()->id,
        ]);

        //???????????????? ?????????????????????? ?????? ??????????????????, ?????????????? ?????? ?????????????????????? ?? ?????????? ??????????
        if($course->course_students && $course->course_students->count()){
            foreach($course->course_students as $student){
                if($request->material_open_id == '0'){
                    $active_opens = 1;
                }else{
                    $active_opens = null;
                }

                /////////////////////
                if($request->material_open_id == '0'){
                    $active_opens = 1;
                    $opened_at = null;
                }else{
                    $active_opens = null;
                }

                if($request->material_open_id == '1'){
                    $opened_at = null;
                }

                //?????????? ?? ???????? ???????????????? ?????????? ?? ????????????????
                $courseWithStudent = $student->student_courses()->where('course_id', $course->id)->first();
                $courseToStudentDate = $courseWithStudent->pivot->created_at;

                //?????????????????? ??????????
                if($request->date_open_days || $request->date_open_days === '0' || $request->date_open_hours || $request->date_open_hours === '0' || $request->date_open_minutes || $request->date_open_minutes === '0'){
                    $opened_at = Carbon::parse($courseToStudentDate)->addDays($request->date_open_days ? $request->date_open_days : 0)->addHours($request->date_open_hours ? $request->date_open_hours : 0)->addMinutes($request->date_open_minutes ? $request->date_open_minutes : 0);
                    //???????????? now ???????????? ???????? ???????? ???????????????? ?????????? ?? ????????????????
                }

                //???????? ???????????????? ?????????? ?????????????????? ????????????
                if($request->date_open_days === null && $request->date_open_hours === null && $request->date_open_minutes === null){
                    $opened_at = null;
                }

                //?????????????????? ?? ?????????????????? ????????
                if($request->opens_after_day){
                    $opened_at = Carbon::parse($request->opens_after_day);
                }

                //?????????????????? ??????????
                if($request->date_close_days || $request->date_close_days === '0' || $request->date_close_hours || $request->date_close_hours === '0' || $request->date_close_minutes || $request->date_close_minutes === '0'){
                    $closed_at = Carbon::parse($courseToStudentDate)->addDays($request->date_close_days ? $request->date_close_days : 0)->addHours($request->date_close_hours ? $request->date_close_hours : 0)->addMinutes($request->date_close_minutes ? $request->date_close_minutes : 0);
                    //???????????? now ???????????? ???????? ???????? ???????????????? ?????????? ?? ????????????????
                }

                //???????? ???????????????? ?????????????????? ????????????
                if($request->date_close_days === null && $request->date_close_hours === null && $request->date_close_minutes === null){
                    $closed_at = null;
                }

                /////////////////////

                // dd($active_opens);

                $admin_id = $teacher->teacher_admins[0]->id;
                $resultNew = Result::create([
                    'student_id' => $student->id,
                    'teacher_id' => $request->user()->id,
                    'material_id' => $materialNew->id,
                    'admin_id' => $admin_id,
                    'active_opens' => $active_opens,
                    'opened_at' => $opened_at,
                    'closed_at' => $closed_at,
                ]);
            }
        };
        

        Session::flash('message', '???????????????? ?????????????? ????????????!');

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
        $opensMaterialIds = Helper::opensMaterialIds();
        $course = $material->course;

        return view('teacher.material_edit', [
            'material' => $material,
            'opensMaterialIds' => $opensMaterialIds,
            'course' => $course,
            // 'upload_files' => $upload_files,
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'material_open_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
              ->withInput()
              ->withErrors($validator);
        }

        $teacher = $request->user();

        if($request->text){
            $texts = $request->text;
            $texts = array_diff($texts, [null]);
            $texts = array_values($texts);

            if(empty($texts)){
                $texts = null;
            }
        }else{
            $texts = null;
        }

        //???????????????? ??????????????
        $date_closing_access = null;
        if($request->date_close_days || $request->date_close_days === '0' || $request->date_close_hours || $request->date_close_hours === '0' || $request->date_close_minutes || $request->date_close_minutes === '0'){
            $date_closing_access = [
                [
                    'days' => $request->date_close_days
                ], 
                [
                    'hours' => $request->date_close_hours
                ], 
                [
                    'minutes' => $request->date_close_minutes
                ]
            ];
        }

        // dd($date_closing_access);
        $upload_file = null;
        if($request->upload_file){
            $upload_file = [];
            foreach($request->upload_file as $key1 => $file_url){
                foreach($request->upload_file_name as $key2 => $file_name){
                    foreach($request->upload_file_type as $key3 => $file_type){
                        if($key1 == $key2 && $key2 == $key3){
                            array_push($upload_file, ['name' => $file_name, 'url' => $file_url, 'type' => $file_type]);
                        }
                    }
                    
                }
            }
        }

        //???????????????????? opens, ???????? ???????????????? ?? ???????????????? ?????? ???????????????????????? ?????????????????????? ?????????? ??????????????????
        if($request->material_open_id == '0' || $request->date_open_days != $material->date_open_days || $request->date_open_hours != $material->date_open_hours || $request->date_open_minutes != $material->date_open_minutes || Carbon::parse($request->opens_after_day) != Carbon::parse($material->opens_after_day)){
            foreach($material->results as $result){
                //???????? ???????????????? ????????????
                if($request->material_open_id == '0'){
                    $resultUpdated = $result->update([
                        'active_opens' => 1,
                        'opened_at' => null,
                    ]);
                }

                if($request->material_open_id == '1' && $request->material_open_id != $material->material_open_id && $result->opened_at != null){
                    if($result->opened_at != null){
                        $resultUpdated = $result->update([
                            'opened_at' => null,
                        ]);
                    }
                }

                //?????????? ?? ???????? ???????????????? ?????????? ?? ????????????????
                $student = $result->result_student;
                $courseWithStudent = $student->student_courses()->where('course_id', $material->course->id)->first();
                $courseToStudentDate = $courseWithStudent->pivot->created_at;

                //?????????????????? ??????????
                if($request->date_open_days && $request->date_open_days != $material->date_open_days || $request->date_open_days === '0' || $request->date_open_hours && $request->date_open_hours != $material->date_open_hours || $request->date_open_hours === '0' || $request->date_open_minutes && $request->date_open_minutes != $material->date_open_minutes || $request->date_open_minutes === '0'){
                    $opened_at = Carbon::parse($courseToStudentDate)->addDays($request->date_open_days ? $request->date_open_days : 0)->addHours($request->date_open_hours ? $request->date_open_hours : 0)->addMinutes($request->date_open_minutes ? $request->date_open_minutes : 0);
                    $resultUpdated = $result->update([
                        'opened_at' => $opened_at,
                    ]);
                }

                //???????? ???????????????? ?????????? ?????????????????? ????????????
                if($request->date_open_days === null && $request->date_open_hours === null && $request->date_open_minutes === null){
                    if($result->opened_at != null){
                        $resultUpdated = $result->update([
                            'opened_at' => null,
                        ]);
                    }
                }

                //?????????????????? ?? ?????????????????? ????????
                if($request->opens_after_day && Carbon::parse($request->opens_after_day) != Carbon::parse($material->opens_after_day)){
                    $opened_at = Carbon::parse($request->opens_after_day);
                    $resultUpdated = $result->update([
                        'opened_at' => $opened_at,
                    ]);
                }

                //?????????????????? ??????????
                $days = $material->date_closing_access ? $material->date_closing_access[0]['days'] : null;
                $hours = $material->date_closing_access ? $material->date_closing_access[1]['hours'] : null;
                $minutes = $material->date_closing_access ? $material->date_closing_access[2]['minutes'] : null;
                if($request->date_close_days && $request->date_close_days != $days || $request->date_close_days === '0' || $request->date_close_hours && $request->date_close_hours != $hours || $request->date_close_hours === '0' || $request->date_close_minutes && $request->date_close_minutes != $minutes || $request->date_close_minutes === '0'){
                    $closed_at = Carbon::parse($courseToStudentDate)->addDays($request->date_close_days ? $request->date_close_days : 0)->addHours($request->date_close_hours ? $request->date_close_hours : 0)->addMinutes($request->date_close_minutes ? $request->date_close_minutes : 0);
                    $resultUpdated = $result->update([
                        'closed_at' => $closed_at,
                    ]);
                }

                //???????? ???????????????? ?????????????????? ????????????
                if($request->date_close_days === null && $request->date_close_hours === null && $request->date_close_minutes === null){
                    if($result->closed_at != null){
                        $resultUpdated = $result->update([
                            'closed_at' => null,
                        ]);
                    }
                }
            }
        }
       

        $materialUpdated = $material->update([
            'title' => $request->title,
            'text' => $texts,
            'video' => $request->video,
            'upload_file' => $upload_file,
            'material_open_id' => $request->material_open_id,
            'material_id' => $request->material_id ? $request->material_id : null,
            'date_open_days' => $request->date_open_days ? $request->date_open_days : null,
            'date_open_hours' => $request->date_open_hours ? $request->date_open_hours : null,
            'date_open_minutes' => $request->date_open_minutes ? $request->date_open_minutes : null,
            'opens_after_day' => $request->opens_after_day ? Carbon::parse($request->opens_after_day) : null,
            'date_closing_access' => $date_closing_access ? $date_closing_access : null,
        ]);

        Session::flash('message', '???????????????????? ?? ?????????????????? ?????????????? ??????????????????!');

        return redirect()->route('materials.edit', ['material' => $material->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();

        Session::flash('message', '???????????????? ?????????????? ?????????????????? ?? ??????????!');

        return back();
    }
}
