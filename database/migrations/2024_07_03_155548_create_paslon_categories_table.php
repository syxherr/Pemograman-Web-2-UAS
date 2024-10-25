<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaslonCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('paslon_categories', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->text('vision_mission');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paslon_categories');
    }
}
