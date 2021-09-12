<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('material_id')->constrained('materials');
            $table->boolean('studied')->nullable();
            $table->timestamp('started_studying', $precision = 0)->nullable();
            $table->timestamp('finished_studying', $precision = 0)->nullable();
            $table->integer('result')->nullable();
            $table->integer('grade')->nullable();
            $table->boolean('active_opens')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->timestamp('opened_at', $precision = 0)->nullable();
            $table->timestamp('closed_at', $precision = 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
