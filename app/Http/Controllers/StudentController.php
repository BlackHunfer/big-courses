<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\Course;
use App\Models\Result;

class StudentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teacher = $request->user();

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
        
        return view('teacher.student_index', [
            'students' => $students,
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
            'first_name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('students.index')
              ->withInput()
              ->withErrors($validator);
        }

        $hashed_random_password = Hash::make(Str::random(8));

        $userNew = $request->user()->create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'password' => $hashed_random_password,
            'email' => $request->email,
            'city_id' => Auth::user()->city_id,
            'tel_phone' => $request->tel_phone,
            'birthday' => Carbon::parse($request->birthday),
            'created_by' => Auth::user()->id,
        ]);

        $teacher = $request->user();

        $admins = $teacher->teacher_admins;
        $admin_id = '';
        foreach($admins as $admin){
            $admin_id = $admin->pivot->admin_id;
        }

        $teacher->admin_students()->attach($request->user()->id, ['admin_id' => $admin_id, 'student_id' => $userNew->id]);
        
        $studentRole = Role::where('slug','student')->first();
        $userNew->roles()->attach($studentRole);

        // Session::flash('message', $request->first_name .' успешно добавлен в список учителей');
        Session::flash('messageNoAutoHide', 'Ссылка для первичной авторизации ученика отправлена на почту ' . $request->email . '. В целях безопасности ссылка будет доступна ученику в течение 24 часов. Если ученик не успеет авторизоваться, то отправьте повторную ссылку со страницы со списком учеников');

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student, Request $request)
    {
        $this->authorize('studentProtected', $student);

        $teacher = $request->user();
        if($request->user()->hasRole('teacher')){
            $admin_id = $teacher->teacher_admins[0]->id;
            $admin = User::find($admin_id);
        }
        if($request->user()->hasRole('administrator')){
            $admin = Auth::user();
        }
        
        $cities = $admin->cities;

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

        return view('teacher.student_edit', [
            'student' => $student,
            'cities' => $cities,
            'courses' => $courses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $student, Request $request)
    {
        $this->authorize('studentProtected', $student);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('students.edit', ['student'=> $student->id])
              ->withInput()
              ->withErrors($validator);
        }

        $studentUpdated = $student->update([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tel_phone' => $request->tel_phone,
            'birthday' => Carbon::parse($request->birthday),
            'city_id' => $request->city_id ? $request->city_id : null,
        ]);

        //Прикрепление курса

        if($request->course){

            $teacher = $request->user();
            $admin_id = $teacher->teacher_admins[0]->id;

            $course = Course::find($request->course);
            $thisCourseStudent = $student->student_courses->where('id', $course->id);
            if($thisCourseStudent && $thisCourseStudent->count()){

            }else{
                $student->student_courses()->attach($course->id);

                foreach($course->materials as $material){
                    if($material->material_open_id === 0){
                        $active_opens = 1;
                    }else{
                        $active_opens = null;
                    }

                    //Если доступ по расписанию
                    if($material->date_open_days || $material->date_open_hours || $material->date_open_minutes){
                        $opened_at = now()->addDays($material->date_open_days ? $material->date_open_days : 0)->addHours($material->date_open_hours ? $material->date_open_hours : 0)->addMinutes($material->date_open_minutes ? $material->date_open_minutes : 0);
                    }else{
                        $opened_at = null;
                    }

                    $resultNew = Result::create([
                        'student_id' => $student->id,
                        'teacher_id' => Auth::user()->id,
                        'material_id' => $material->id,
                        'admin_id' => $admin_id,
                        'active_opens' => $active_opens,
                        'opened_at' => $opened_at,
                    ]);
                    
                }
            }

        }

        Session::flash('message', 'Информация об ученике успешно сохранена!');

        return redirect()->route('students.edit', ['student'=> $student->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $student)
    {
        $this->authorize('studentProtected', $student);

        $student->delete();

        Session::flash('message', 'Ученик перемещен в архив');

        return redirect()->route('students.index');
    }

    public function updateLetter(User $student, Request $request)
    {
        $this->authorize('studentProtected', $student);

        $userEmail = array('email' => $student->email);
        $status = Password::sendResetLink(
            $userEmail
        );

        Session::flash('messageNoAutoHide', 'Ссылка для первичной авторизации ученика отправлена на почту ' . $student->email . '. В целях безопасности ссылка будет доступна ученику в течение 24 часов. Если ученик не успеет авторизоваться, то отправьте повторную ссылку со страницы со списком учеников');

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($userEmail)
                            ->withErrors(['email' => __($status)]);
    }
}
