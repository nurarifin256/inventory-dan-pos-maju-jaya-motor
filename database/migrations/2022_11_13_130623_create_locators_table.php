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
        Schema::create('locators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id');
            $table->foreignId('rack_id');
            $table->bigInteger('no');
            $table->tinyInteger('trashed')->default(0);
            $table->string('created_by', 25);
            $table->string('updated_by', 25);
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
        Schema::dropIfExists('locators');
    }
};
