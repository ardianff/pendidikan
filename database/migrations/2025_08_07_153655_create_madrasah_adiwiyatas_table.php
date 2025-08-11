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
        Schema::create('madrasah_adiwiyatas', function (Blueprint $table) {
            $table->id();
            $table->string('nsm');
            $table->string('nspn')->nullable();
            $table->unsignedBigInteger('jenjang');
            $table->string('tahun');
            $table->unsignedBigInteger('tingkat');
            $table->boolean('terbentuk_tim');
            $table->text('dok_sk_tim')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tingkat')->references('id')->on('master_jenjang_adiwiyatas')->onDelete('cascade');
            $table->foreign('jenjang')->references('id')->on('master_jenjang_madrasahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('madrasah_adiwiyatas');
    }
};
