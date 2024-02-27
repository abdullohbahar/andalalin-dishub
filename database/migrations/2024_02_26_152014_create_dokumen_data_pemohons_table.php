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
        Schema::create('dokumen_data_pemohons', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('data_pemohon_id')->nullable();
            $table->foreign('data_pemohon_id')->references('id')->on('data_pemohons')->nullOnDelete();
            $table->text('surat_permohonan')->nullable();
            $table->text('dokumen_site_plan')->nullable();
            $table->text('surat_aspek_tata_ruang')->nullable();
            $table->text('sertifikat_tanah')->nullable();
            $table->text('kkop')->nullable();
            $table->text('is_verified')->nullable();
            $table->text('alasan')->nullable();
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
        Schema::dropIfExists('dokumen_data_pemohons');
    }
};
