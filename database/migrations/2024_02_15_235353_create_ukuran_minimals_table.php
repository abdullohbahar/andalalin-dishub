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
        Schema::create('ukuran_minimals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_jenis_rencana_id')->nullable();
            $table->foreign('sub_jenis_rencana_id')->references('id')->on('sub_jenis_rencanas')->nullOnDelete();
            $table->unsignedBigInteger('sub_sub_jenis_rencana_id')->nullable();
            $table->foreign('sub_sub_jenis_rencana_id')->references('id')->on('sub_sub_jenis_rencanas')->nullOnDelete();
            $table->text('keterangan');
            $table->text('kategori');
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
        Schema::dropIfExists('ukuran_minimals');
    }
};
