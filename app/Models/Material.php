<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Theme;
use App\Models\Course;

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
    ];

    protected $casts = [
        'text' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
