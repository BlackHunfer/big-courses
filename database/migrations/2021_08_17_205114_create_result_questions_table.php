<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->foreignId('result_id');
            $table->text('student_answer')->nullable();
            $table->boolean('student_correct')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_questions');
    }
}
