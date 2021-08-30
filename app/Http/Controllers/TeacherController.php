<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Speciality;
use App\Http\Controllers\Auth\PasswordResetLinkController;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin = $request->user();
        $teachers = $admin->admin_teachers()
        ->orderBy('id', 'asc')
        ->get();

        $cities = $admin->cities;

        $specialities = $admin->specialities()
            ->where("city_id", null)
            ->orderBy('id', 'asc')
            ->get();

        return view('administrator.teacher_index', [
            'teachers' => $teachers,
            'cities' => $cities,
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
            'first_name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('teachers.index')
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
            'city_id' => $request->city_id ? $request->city_id : null,
            'speciality_id' => $request->speciality_id ? $request->speciality_id : null,
        ]);

        $admin = $request->user();
        $admin->admin_teachers()->attach($request->user()->id, ['admin_id' => $request->user()->id, 'teacher_id' => $userNew->id]);

        
        $teacherRole = Role::where('slug','teacher')->first();
        $userNew->roles()->attach($teacherRole);

        // Session::flash('message', $request->first_name .' успешно добавлен в список учителей');
        Session::flash('messageNoAutoHide', 'Ссылка для первичной авторизации учителя отправлена на почту ' . $request->email . '. В целях безопасности ссылка будет доступна учителю в течение 24 часов. Если учитель не успеет авторизоваться, то отправьте повторную ссылку со страницы со списком учителей');

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
    public function edit(User $teacher, Request $request)
    {
        $this->authorize('teacherProtected', $teacher);

        $admin = $request->user();
        $cities = $admin->cities;

        $specialities = $admin->specialities()
            ->where("city_id", null)
            ->orderBy('id', 'asc')
            ->get();
       

        return view('administrator.teacher_edit', [
            'teacher' => $teacher,
            'cities' => $cities,
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
    public function update(User $teacher, Request $request)
    {
        $this->authorize('teacherProtected', $teacher);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('teachers.edit', ['teacher'=> $teacher->id])
              ->withInput()
              ->withErrors($validator);
        }

        $teacherUpdated = $teacher->update([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'city_id' => $request->city_id ? $request->city_id : null,
            'speciality_id' => $request->speciality_id ? $request->speciality_id : null,
        ]);

        Session::flash('message', 'Информация об учителе успешно сохранена!');

        return redirect()->route('teachers.edit', ['teacher'=> $teacher->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $teacher)
    {
        $this->authorize('teacherProtected', $teacher);

        $teacher->delete();

        Session::flash('message', 'Учитель перемещен в архив');

        return redirect()->route('teachers.index');
    }

    public function updateLetter(User $teacher, Request $request)
    {
        $this->authorize('teacherProtected', $teacher);

        $userEmail = array('email' => $teacher->email);
        $status = Password::sendResetLink(
            $userEmail
        );

        Session::flash('messageNoAutoHide', 'Ссылка для первичной авторизации учителя отправлена на почту ' . $teacher->email . '. В целях безопасности ссылка будет доступна учителю в течение 24 часов. Если учитель не успеет авторизоваться, то отправьте повторную ссылку со страницы со списком учителей');

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($userEmail)
                            ->withErrors(['email' => __($status)]);
    }
}
