<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('created_by')->constrained('users')->nullable();
            $table->foreignId('theme_id')->constrained('themes')->nullable();
            $table->foreignId('material_type_id')->constrained('material_types');
            $table->foreignId('material_open_id')->constrained('material_opens');
            $table->text('text')->nullable();
            $table->text('upload_file')->nullable(); //файл учителя
            $table->text('video')->nullable();  //видео учителя
            // $table->foreignId('test_id')->constrained('tests')->nullable(); //Прикрепленный тест к материалу
            $table->foreignId('material_id')->constrained('materials')->nullable(); //Открывается только после прохождения выбранного материала или прошлого материала
            $table->integer('opens_after_day')->nullable(); // Материал откроется после выбранного количества дней с момента регистрации
            // $table->date('open_from')->nullable(); //Тест открывается такого то числа
            // $table->date('open_to')->nullable(); //Тест закрывается такого то числа
            // $table->time('time_for_test')->nullable();
            // $table->boolean('education')->nullable();
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
