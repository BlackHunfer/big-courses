<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Group;
use App\Models\Material;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\ResetPasswordTeacher;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsToMany(User::class, 'admin_teacher', 'admin_id', 'teacher_id')->withTimestamps();
    }

    public function sendPasswordResetNotification($token)
    {
        if (Auth::check()) {
            if(Auth::user()->hasRole('administrator')){
                $this->notify(new ResetPasswordTeacher($token));
            }
        }else{
            $this->notify(new ResetPassword($token));
        }
       
        
    }
}
