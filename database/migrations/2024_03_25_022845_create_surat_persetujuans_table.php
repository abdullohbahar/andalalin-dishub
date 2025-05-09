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
        Schema::create('surat_persetujuans', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('pengajuan_id')->nullable()->references('id')->on('pengajuans')->nullOnDelete();

            $table->boolean('is_kasi_approve')->default(0);
            $table->boolean('is_kabid_approve')->default(0);
            $table->boolean('is_kadis_approve')->default(0);
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
        Schema::dropIfExists('surat_persetujuans');
    }
};
