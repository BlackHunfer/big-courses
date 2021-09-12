<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Material;

class Result extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'teacher_id',
        'admin_id',
        'material_id',
        'studied',
        'started_studying',
        'finished_studying',
        'result',
        'grade',
        'active_opens',
        'opened_at',
        'closed_at',
    ];

    public function material() 
    {
        return $this->belongsTo(Material::class);
    }

    public function result_admin()
    {
        return $this->belongsTo(User::class);
    }

    public function result_teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function result_student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
}
