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
        Schema::create('locator_barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('locator_id');
            $table->unsignedBigInteger('barang_masuk_detail_id');
            $table->foreign('locator_id')->references('id')->on('locators')->cascadeOnDelete();
            $table->foreign('barang_masuk_detail_id')->references('id')->on('barang_masuk_details')->cascadeOnDelete();
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
        Schema::dropIfExists('locator_barangs');
    }
};
