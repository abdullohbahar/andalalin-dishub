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
        Schema::create('sub_sub_jenis_rencanas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_jenis_rencana_id')->nullable();
            $table->foreign('sub_jenis_rencana_id')->references('id')->on('sub_jenis_rencanas')->nullOnDelete();
            $table->text('nama');
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
        Schema::dropIfExists('sub_sub_jenis_rencanas');
    }
};
