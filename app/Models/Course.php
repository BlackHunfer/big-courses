<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;
use App\Models\Theme;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'admin_id',
        'speciality_id',
        'created_by',
    ];

    public function course_admin()
    {
        return $this->belongsTo(User::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

}
