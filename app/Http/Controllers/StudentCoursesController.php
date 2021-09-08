<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\Result;

class StudentCoursesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $student = $request->user();

        $courses = $student->student_courses()->get();

        return view('student.course_index', [
            'courses' => $courses,
        ]);
    }

    public function show(Course $course, Request $request)
    {

        //Обновление active_opens материалам с последовательным доступом после изучения
        $opensWithMaterialIds = [];
        $notOpensWithMaterialIds = [];

        foreach($course->materials as $materialCourse){
            if($materialCourse->material_id != null){
                foreach($materialCourse->for_opens_materials as $for_opens_material){
                    foreach($for_opens_material->results_for_student as $result){
                        if($result->studied == 1){
                            array_push($opensWithMaterialIds, $materialCourse->id);
                        }else{
                            array_push($notOpensWithMaterialIds, $materialCourse->id);
                        }
                    }
                }
            }
            //Обновление active_opens материалам с доступом по расписанию
            foreach($materialCourse->results_for_student as $result){
                if($result->opened_at && now() > $result->opened_at){
                    array_push($opensWithMaterialIds, $materialCourse->id);
                }else if($result->opened_at && now() < $result->opened_at){
                    array_push($notOpensWithMaterialIds, $materialCourse->id);
                }
            }

        }

       
        
        if(!empty($opensWithMaterialIds)){
            
            $resultWithOpensMaterial = $request->user()->student_results
                ->whereIn('material_id', $opensWithMaterialIds)
                ->where('active_opens', '!=', 1);  
            
            foreach($resultWithOpensMaterial as $resultWithOpen){
                $resultWithOpenUpdated = $resultWithOpen->update([
                    'active_opens' => 1,
                ]);
            }
        }

        if(!empty($notOpensWithMaterialIds)){

            $resultWithOpensMaterial = $request->user()->student_results
                ->whereIn('material_id', $notOpensWithMaterialIds)
                ->where('active_opens', 1);

            foreach($resultWithOpensMaterial as $resultWithOpen){
                $resultWithOpenUpdated = $resultWithOpen->update([
                    'active_opens' => null,
                ]);
            }
        }

        //

        $themes = $course->themes()
            ->whereNull('theme_id')
            ->with('childrenThemes')
            ->orderBy('id', 'asc')// поменять на order
            ->get();

        return view('student.course_show', [
            'course' => $course,
            'themes' => $themes,
        ]);
    }

    public function startMaterial(Request $request, Course $course, Material $material)
    {

 
        $result = $request->user()->student_results->where('material_id', $material->id)->first();

        $resultUpdated = $result->update([
            'studied' => 1,
        ]);


        // $opensWithMaterialIds = [];
        // foreach($course->materials as $materialCourse){
        //     if($materialCourse->material_id == $material->id){
        //         array_push($opensWithMaterialIds, $materialCourse->id);
        //     }
        // }
        // if(!empty($opensWithMaterialIds)){

        //     $resultWithOpensMaterial = $request->user()->student_results
        //         ->whereIn('material_id', $opensWithMaterialIds);

        //     foreach($resultWithOpensMaterial as $resultWithOpen){
        //         $resultWithOpenUpdated = $resultWithOpen->update([
        //             'active_opens' => 1,
        //         ]);
        //     }
        // }
        
    }
}
