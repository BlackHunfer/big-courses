<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id');
            $table->foreignId('user_id');
            $table->date('date_start')->nullable(); //Дата фактического начала
            $table->date('date_end')->nullable(); //Дата фактического конца (Чтобы посчитать время прохождения теста)
            $table->foreignId('test_status_id');
            $table->text('upload_file')->nullable();
            $table->text('result')->nullable(); //Баллы
            $table->text('grade')->nullable(); //Оценка
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
        Schema::dropIfExists('material_user');
    }
}
