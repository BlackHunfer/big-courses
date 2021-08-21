<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\ResultQuestion;

class MaterialUser extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'result_questions')->withPivot('student_answer', 'student_correct')->using(ResultQuestion::class);
    }
}
