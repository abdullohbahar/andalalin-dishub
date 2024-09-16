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
            $table->longText('body_prakonstruksi')->nullable()->after('body');
            $table->longText('body_konstruksi')->nullable()->after('body_prakonstruksi');
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
