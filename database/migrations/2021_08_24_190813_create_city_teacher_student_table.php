<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityTeacherStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_teacher_student', function (Blueprint $table) {
            $table->foreignId('city_id')
                ->constrained('cities');
            $table->foreignId('teacher_id')
                ->constrained('users');
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_teacher_student');
    }
}
