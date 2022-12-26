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
        Schema::create('barang_masuk_detail_laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id');
            $table->foreignId('barang_id');
            $table->foreignId('merek_id');
            $table->bigInteger('qty');
            $table->tinyInteger('trashed')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('created_by', 50);
            $table->string('updated_by', 50);
            $table->timestamps();

            $table->index(['barang_id', 'merek_id', 'barang_masuk_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuk_detail_laporans');
    }
};
