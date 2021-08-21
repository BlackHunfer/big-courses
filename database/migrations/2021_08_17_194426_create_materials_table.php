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
            $table->foreignId('theme_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('material_type_id');
            $table->string('title');
            $table->text('upload_file')->nullable();
            $table->text('text')->nullable();
            $table->integer('order')->nullable();
            $table->date('open_from')->nullable(); //Тест открывается такого то числа
            $table->date('open_to')->nullable(); //Тест закрывается такого то числа
            $table->time('time_for_test')->nullable();
            $table->boolean('education')->nullable();
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
        Schema::dropIfExists('materials');
    }
}
