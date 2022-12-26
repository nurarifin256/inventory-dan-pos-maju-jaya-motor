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
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->default(0);
            $table->decimal('total', $precision = 8, $scale = 2);
            $table->tinyInteger('trashed')->default(0);
            $table->string('created_by', 125);
            $table->string('updated_by', 125);
            $table->timestamps();

            $table->index(['pelanggan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_keluars');
    }
};
