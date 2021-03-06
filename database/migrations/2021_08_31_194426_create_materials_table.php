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
            $table->integer('material_type_id')->nullable();
            $table->integer('material_open_id')->nullable();
            $table->json('text')->nullable();
            $table->text('upload_file')->nullable(); //файл учителя
            $table->text('video')->nullable();  //видео учителя
            // $table->foreignId('test_id')->constrained('tests')->nullable(); //Прикрепленный тест к материалу
            $table->foreignId('material_id')->constrained('materials')->nullable(); //Открывается только после прохождения выбранного материала или прошлого материала
            $table->timestamp('opens_after_day', $precision = 0)->nullable();
            $table->integer('date_open_days')->nullable();
            $table->integer('date_open_hours')->nullable();
            $table->integer('date_open_minutes')->nullable(); // Материал откроется после выбранного количества дней с момента регистрации
            $table->json('date_closing_access')->nullable();
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
