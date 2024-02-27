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
        Schema::create('data_pemohons', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->foreign('pengajuan_id')->references('id')->on('pengajuans')->nullOnDelete();
            $table->foreignUuid('konsultan_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->string('nama_pimpinan')->nullable();
            $table->string('jabatan_pimpinan')->nullable();
            $table->string('nama_proyek')->nullable();
            $table->string('nama_jalan')->nullable();
            $table->string('luas_bangunan')->nullable();
            $table->string('luas_tanah')->nullable();
            $table->text('alamat')->nullable();
            $table->text('nomor_surat_permohonan')->nullable();
            $table->date('tanggal_surat_permohonan')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
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
        Schema::dropIfExists('data_pemohons');
    }
};
