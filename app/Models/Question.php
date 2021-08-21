<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MaterialUser;
use App\Models\ResultQuestion;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'material_id',
        'text',
        'hint',
    ];

    public function materialusers()
    {
        return $this->belongsToMany(MaterialUser::class, 'result_questions')->withPivot('student_answer', 'student_correct')->using(ResultQuestion::class);
    }
}
