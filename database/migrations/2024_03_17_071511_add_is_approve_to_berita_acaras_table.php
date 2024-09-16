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
        Schema::table('berita_acaras', function (Blueprint $table) {
            $table->boolean('is_penilai_1_approve')->after('nomor')->default(0);
            $table->boolean('is_penilai_2_approve')->after('nomor')->default(0);
            $table->boolean('is_penilai_3_approve')->after('nomor')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('berita_acaras', function (Blueprint $table) {
            //
        });
    }
};
