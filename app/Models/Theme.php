<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Theme;
use App\Models\Material;

class Theme extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'course_id',
        'theme_id',
        'order',
        'created_by',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function childrenThemes()
    {
        return $this->hasMany(Theme::class)->with('themes');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }


    public function materialsCourseStudent()
    {
        return $this->materials()->whereHas('results', function ($query) {
            $query->where('student_id', Auth::user()->id)
                ->where('active_opens', '1');
        });
    }
}
