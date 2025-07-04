<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_kota_kabs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kota_kab');
            $table->string('kode_parent')->nullable();
            $table->string('kode_bps')->nullable();
            $table->string('nama')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kota_kabs');
    }
};
