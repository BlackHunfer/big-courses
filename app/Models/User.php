<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\ResetPasswordTeacher;
use App\Notifications\ResetPasswordStudent;
use App\Models\User;
use App\Models\City;
use App\Models\Group;
use App\Models\Material;



class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndPermissions, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'city_id',
        'password',
        'first_name',
        'second_name',
        'last_name',
        'tel_phone',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    
    public function materials()
    {
        return $this->belongsToMany(Material::class)->withPivot('date_start', 'date_end', 'upload_file', 'result', 'grade')->withTimestamps();
    }

    public function admin_teachers() 
    {
        return $this->belongsToMany(User::class, 'admin_teacher', 'admin_id', 'teacher_id')->withPivot('admin_id', 'teacher_id')->withTimestamps();
    }
    public function teacher_admins() 
    {
        return $this->belongsToMany(User::class, 'admin_teacher', 'teacher_id', 'admin_id')->withPivot('admin_id', 'teacher_id')->withTimestamps();
    }

    public function admin_students() 
    {
        return $this->belongsToMany(User::class, 'admin_student', 'admin_id', 'student_id')->withPivot('admin_id', 'student_id')->withTimestamps();
    }
    public function student_admins() 
    {
        return $this->belongsToMany(User::class, 'admin_student','student_id', 'admin_id')->withPivot('admin_id', 'student_id')->withTimestamps();
    }


    public function teacher_cities() 
    {
        return $this->belongsToMany(City::class, 'city_teacher_student', 'teacher_id', 'city_id')->withPivot('student_id', 'city_id', 'teacher_id');
    }
    public function student_cities() 
    {
        return $this->belongsToMany(City::class, 'city_teacher_student', 'city_id', 'student_id')->withPivot('student_id', 'city_id', 'student_id');
    }



    public function sendPasswordResetNotification($token)
    {
        if (Auth::check()) {
            if(Auth::user()->hasRole('administrator')){
                $this->notify(new ResetPasswordTeacher($token));
            }
            if(Auth::user()->hasRole('teacher')){
                $this->notify(new ResetPasswordStudent($token));
            }
        }else{
            $this->notify(new ResetPassword($token));
        }
       
        
    }
}