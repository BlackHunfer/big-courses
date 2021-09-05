<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
}
