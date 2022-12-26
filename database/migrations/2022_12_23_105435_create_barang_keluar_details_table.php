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
        Schema::create('barang_keluar_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_keluar_id');
            $table->foreignId('barang_id');
            $table->foreignId('merek_id');
            $table->bigInteger('qty');
            $table->string('not_in', 25);
            $table->string('created_by', 50);
            $table->string('updated_by', 50);
            $table->tinyInteger('trashed')->default(0);
            $table->timestamps();

            $table->index(['barang_keluar_id', 'barang_id', 'merek_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_keluar_details');
    }
};
