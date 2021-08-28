<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'address',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


    // public function city_teachers() 
    // {
    //     return $this->belongsToMany(User::class, 'city_teacher_student', 'city_id',  'teacher_id')->withPivot('student_id', 'city_id', 'teacher_id');
    // }
    // public function city_students() 
    // {
    //     return $this->belongsToMany(User::class, 'city_teacher_student', 'city_id', 'student_id')->withPivot('student_id', 'city_id', 'teacher_id');
    // }
    
}
