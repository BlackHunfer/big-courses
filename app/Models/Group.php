<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Speciality;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'speciality_id',
        'admin_id',
        'city_id',
        'created_by',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'group_student', 'group_id', 'student_id')->withPivot('group_id', 'student_id');
    }

    public function group_admin()
    {
        return $this->hasMany(User::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
}
