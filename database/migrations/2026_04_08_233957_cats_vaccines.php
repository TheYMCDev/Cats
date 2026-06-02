<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatsVaccines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccines_cats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vaccine_id');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->foreignId('cat_id')->constrained('cats');
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
        Schema::dropIfExists('vaccines_cats');
    }
}
