<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = $request->user()->cities()->orderBy('id', 'desc')->get();

        return view('administrator.city_index', [
            'cities' => $cities,
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
            return redirect()->route('cities.index')
              ->withInput()
              ->withErrors($validator);
        }


        $cityNew = $request->user()->cities()->create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'address' => $request->address,
        ]);

        Session::flash('message', 'Филиал успешно добавлен!');

        return redirect()->route('cities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('administrator.city_edit', [
            'city' => $city,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('cities.index')
              ->withInput()
              ->withErrors($validator);
        }

        $cityUpdated = $city->update([
            'title' => $request->title,
            'address' => $request->address,
        ]);

        Session::flash('message', 'Информация о филиале успешно сохранена!');

        return redirect()->route('cities.edit', ['city'=> $city->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {

        $users = User::withTrashed()
            ->where("city_id", $city->id)
            ->get();

        foreach($users as $user){
            $user->update([
                'city_id' => null,
            ]);
        }

        $city->delete();

        Session::flash('message', 'Филиал успешно удален! Связанные учителя и ученики теперь не имеют филиала');

        return redirect()->route('cities.index');
    }
}
