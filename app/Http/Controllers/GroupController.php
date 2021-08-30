<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Group;
use App\Models\Speciality;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teacher = $request->user();

        //Группы
        if(isset($teacher->city_id)){
            $groups = Group::where("city_id", $teacher->city_id)
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
            $groups = $admin->admin_groups()
                ->where("city_id", null)
                ->orderBy('id', 'asc')
                ->get();
        }

        //Ученики
        if(isset($teacher->city_id)){
            $students = User::whereHas('roles', function ($query) {
                    $query->where('slug', 'student');
                })
                ->where("city_id", $teacher->city_id)
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
            $students = $admin->admin_students()
                ->where("city_id", null)
                ->orderBy('id', 'asc')
                ->get();
        }

        //Специальности
        // if(isset($teacher->city_id)){
        //     $specialities = Speciality::where("city_id", $teacher->city_id)
        //         ->orderBy('id', 'asc')
        //         ->get();
        // }else{
        //     if($request->user()->hasRole('teacher')){
        //         $admin_id = $teacher->teacher_admins[0]->id;
        //         $admin = User::find($admin_id);
        //     }
        //     if($request->user()->hasRole('administrator')){
        //         $admin = Auth::user();
        //     }
        //     $specialities = $admin->specialities()
        //         ->where("city_id", null)
        //         ->orderBy('id', 'asc')
        //         ->get();
        // }

        if($request->user()->hasRole('teacher')){
            $admin_id = $teacher->teacher_admins[0]->id;
            $admin = User::find($admin_id);
        }
        if($request->user()->hasRole('administrator')){
            $admin = Auth::user();
        }
        $specialities = $admin->specialities()
            ->where("city_id", null)
            ->orderBy('id', 'asc')
            ->get();


        return view('teacher.group_index', [
            'groups' => $groups,
            'students' => $students,
            'specialities' => $specialities,
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
            'students_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('groups.index')
              ->withInput()
              ->withErrors($validator);
        }

        $teacher = $request->user();
        $admin_id = $teacher->teacher_admins[0]->id;

        

        $groupNew = Group::create([
            'title' => $request->title,
            'admin_id' => $admin_id,
            'city_id' => Auth::user()->city_id,
            'speciality_id' => $request->speciality_id ? $request->speciality_id : null,
            'created_by' => Auth::user()->id,
        ]);

        foreach($request->students_id as $student_id){
            $groupNew->students()->attach($student_id, ['group_id' => $groupNew->id, 'student_id' => $student_id]);
        }


        Session::flash('message', 'Группа учеников успешно создана!');

        return redirect()->route('groups.index');
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
    public function edit(Request $request, Group $group)
    {
        $this->authorize('groupProtected', $group);

        $teacher = $request->user();

        //Ученики
        if(isset($teacher->city_id)){
            $students = User::whereHas('roles', function ($query) {
                    $query->where('slug', 'student');
                })
                ->where("city_id", $teacher->city_id)
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
            $students = $admin->admin_students()
                ->where("city_id", null)
                ->orderBy('id', 'asc')
                ->get();
        }

        //Специальности
        // if(isset($teacher->city_id)){
        //     $specialities = Speciality::where("city_id", $teacher->city_id)
        //         ->orderBy('id', 'asc')
        //         ->get();
        // }else{
        //     if($request->user()->hasRole('teacher')){
        //         $admin_id = $teacher->teacher_admins[0]->id;
        //         $admin = User::find($admin_id);
        //     }
        //     if($request->user()->hasRole('administrator')){
        //         $admin = Auth::user();
        //     }
        //     $specialities = $admin->specialities()
        //         ->where("city_id", null)
        //         ->orderBy('id', 'asc')
        //         ->get();
        // }

        if($request->user()->hasRole('teacher')){
            $admin_id = $teacher->teacher_admins[0]->id;
            $admin = User::find($admin_id);
        }
        if($request->user()->hasRole('administrator')){
            $admin = Auth::user();
        }
        $specialities = $admin->specialities()
            ->where("city_id", null)
            ->orderBy('id', 'asc')
            ->get();


        return view('teacher.group_edit', [
            'group' => $group,
            'students' => $students,
            'specialities' => $specialities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize('groupProtected', $group);

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'students_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('groups.index')
              ->withInput()
              ->withErrors($validator);
        }

        // dd("сделать детач всех пользователей этой группы или сделать проверку по существующим связям");

        $groupUpdated = $group->update([
            'title' => $request->title,
            'speciality_id' => $request->speciality_id ? $request->speciality_id : null,
        ]);


        $oldStudents = [];
        foreach($group->students as $studenInGroup){
            array_push($oldStudents, $studenInGroup->id);
        }
        // dd($oldStudents);

        $newStudents = [];
        foreach($request->students_id as $student_id){
            array_push($newStudents, (int)$student_id);
        }
        // dd($newStudents);

        $detachStudents = [];
        $attachStudents = [];
        foreach($newStudents as $newStudent){
            if($oldStudents != null){
                foreach($oldStudents as $oldStudent){
                    if(!in_array($newStudent, $oldStudents)){
                        array_push($attachStudents, $newStudent);
                    }
                    if(!in_array($oldStudent, $newStudents)){
                        array_push($detachStudents, $oldStudent);
                    }
                }
            }else{
                array_push($attachStudents, $newStudent);
            }
        }

        $detachStudents = array_unique($detachStudents);
        $attachStudents = array_unique($attachStudents);
                                                    
        foreach($detachStudents as $detachStudent_id){
            $group->students()->detach($detachStudent_id);
        }

        foreach($attachStudents as $attachStudent_id){
            $group->students()->attach($attachStudent_id, ['group_id' => $group->id, 'student_id' => $attachStudent_id]);
        }

        Session::flash('message', 'Информация о группе успешно сохранена!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('groupProtected', $group);

        $group->students()->detach();
        $group->delete();

        Session::flash('message', 'Группа успешно удалена и распущена');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ungroup(Group $group, User $student)
    {
        $this->authorize('groupProtected', $group);

        $group->students()->detach($student->id);

        Session::flash('message', $student->second_name . ' '. $student->first_name . ' ' . $student->last_name . ' откреплен от группы ' . $group->title);
    
        return back();
    }
}
