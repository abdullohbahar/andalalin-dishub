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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('jenis_rencana_id')->nullable();
            $table->foreign('jenis_rencana_id')->references('id')->on('jenis_rencana_pembangunans')->nullOnDelete();
            $table->unsignedBigInteger('sub_jenis_rencana_id')->nullable();
            $table->foreign('sub_jenis_rencana_id')->references('id')->on('sub_jenis_rencanas')->nullOnDelete();
            $table->unsignedBigInteger('sub_sub_jenis_rencana_id')->nullable();
            $table->foreign('sub_sub_jenis_rencana_id')->references('id')->on('sub_sub_jenis_rencanas')->nullOnDelete();
            $table->unsignedBigInteger('ukuran_minimal_id')->nullable();
            $table->foreign('ukuran_minimal_id')->references('id')->on('ukuran_minimals')->nullOnDelete();
            $table->unsignedBigInteger('jenis_jalan_id')->nullable();
            $table->foreign('jenis_jalan_id')->references('id')->on('jenis_jalans')->nullOnDelete();
            $table->foreignUuid('konsultan_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->string('jenis_pengajuan');
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
        Schema::dropIfExists('pengajuans');
    }
};
