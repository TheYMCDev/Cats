<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 50);
            $table->integer('age', )->nullable();
            $table->decimal('weight')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('race', ['siames', 'gato europeo', 'gay', 'sin raza'])->default('sin raza');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cats');
    }
}
