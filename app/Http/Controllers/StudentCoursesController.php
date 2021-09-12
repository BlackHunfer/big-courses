<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
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

                if($result->closed_at && now() > $result->closed_at){
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
        $result = $material->result_for_student($material->id);

        $resultUpdated = $result->update([
            'started_studying' => $result->started_studying ?? now(),
        ]);

        return redirect()->route('student.materials.show', [
            'course' => $course, 
            'material' => $material
        ]);
    }

    public function finishMaterial(Request $request, Course $course, Material $material)
    {
        $result = $material->result_for_student($material->id);

        $resultUpdated = $result->update([
            'finished_studying' => $result->finished_studying ?? now(),
            'studied' => $result->studied ?? 1,
        ]);

        return redirect()->route('student.courses.show', [
            'course' => $course
        ]);
    }

    public function showMaterial(Request $request, Course $course, Material $material)
    {   
        if($material->material_type_id == 0){
            if($material->text){
                $texts = $material->text;
                $texts = $this->paginate($texts);
                $texts->withPath('');
                $textsTotal = $texts->total();
                $textsOnePrecent = 100 / $textsTotal;
            }
        }

        return view('student.material_show', [
            'course' => $course,
            'material' => $material,
            'texts' => $texts ?? null,
            'textsTotal' => $textsTotal ?? null,
            'textsOnePrecent' => $textsOnePrecent ?? null,
        ]);
    }

    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
