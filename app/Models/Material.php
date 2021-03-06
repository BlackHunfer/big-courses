<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Theme;
use App\Models\Course;
use App\Models\Result;

class Material extends Model
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
        'material_type_id',
        'material_open_id',
        'upload_file',
        'video',
        'text',
        'material_id',
        'opens_after_day',
        'order',
        'created_by',
        'date_open_days',
        'date_open_hours',
        'date_open_minutes',
        'date_closing_access',
    ];

    protected $casts = [
        'text' => 'array',
        'date_closing_access' => 'array',
        'upload_file' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function results() 
    {
        return $this->hasMany(Result::class);
    }

    public function results_for_student() 
    {
        return $this->results()->where("student_id", Auth::user()->id);
    }

    public function result_for_student($material_id) 
    {
        return $this->results()->where("student_id", Auth::user()->id)->where('material_id', $material_id)->first();
    }

    public function for_opens_materials() 
    {
        return $this->hasMany(Material::class, 'id', 'material_id');
    }

    public function for_opens_material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    // public function results_for_student_studied() 
    // {
    //     return $this->results()->where("student_id", Auth::user()->id)->where('studied', 1);
    // }
}
