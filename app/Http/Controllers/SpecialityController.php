<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Speciality;
use App\Models\Group;
use App\Models\User;

class SpecialityController extends Controller
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
            $specialities = Speciality::where("city_id", $teacher->city_id)
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
            $specialities = $admin->specialities()
                ->where("city_id", null)
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('teacher.speciality_index', [
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('specialities.index')
              ->withInput()
              ->withErrors($validator);
        }

        $teacher = $request->user();
        $admin_id = $teacher->teacher_admins[0]->id;

        $specialityNew = $request->user()->specialities()->create([
            'title' => $request->title,
            'admin_id' => $admin_id,
            'city_id' => Auth::user()->city_id,
            'created_by' => Auth::user()->id,
        ]);

        Session::flash('message', 'Специальность успешно добавлена!');

        return redirect()->route('specialities.index');
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
    public function edit(Speciality $speciality)
    {
        return view('teacher.speciality_edit', [
            'speciality' => $speciality,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speciality $speciality)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('specialities.index')
              ->withInput()
              ->withErrors($validator);
        }

        $specialityUpdated = $speciality->update([
            'title' => $request->title,
        ]);

        Session::flash('message', 'Информация о специальности успешно сохранена!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speciality $speciality)
    {
        $groups = Group::withTrashed()
            ->where("speciality_id", $speciality->id)
            ->get();

        foreach($groups as $group){
            $group->update([
                'speciality_id' => null,
            ]);
        }

        $speciality->delete();

        Session::flash('message', 'Специальность успешно удалена! Связанные группы теперь не имеют специальности');

        return redirect()->route('specialities.index');
    }
}
