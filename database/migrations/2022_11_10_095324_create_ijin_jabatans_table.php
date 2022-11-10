<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ijin_jabatans', function (Blueprint $table) {
            $table->unsignedBigInteger('ijin_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->foreign('ijin_id')->references('id')->on('ijins')->cascadeOnDelete();
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->cascadeOnDelete();
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
        Schema::dropIfExists('ijin_jabatans');
    }
};
