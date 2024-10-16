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
        Schema::create('alternatifnbs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alternatif');
            $table->unsignedBigInteger('kriteria');
            $table->double('bobot')->default(0,00000);
            $table->double('nilai')->default(0,00000);
            $table->unsignedBigInteger('periode');
            $table->enum('status',['Awal','Baru','Lama'])->default('Awal');
            $table->timestamps();
        });
        schema::table('alternatifnbs', function($table){
            $table->foreign('periode')->references('id')->on('periodes')->onDelete('cascade');
            $table->foreign('alternatif')->references('id')->on('alternatifs')->onDelete('cascade');
            $table->foreign('kriteria')->references('id')->on('kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatifnbs');
        Schema::dropForeign(['alternatif']);
        Schema::dropForeign(['kriteria']);
        Schema::dropForeign(['periodes']);
    }
};
