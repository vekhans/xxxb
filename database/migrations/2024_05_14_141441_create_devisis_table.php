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
        Schema::create('devisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('periode');
            $table->enum('status',['Tidak Konsisten','Konsisten'])->default('Tidak Konsisten');
            $table->timestamps();
        });
        schema::table('devisis', function($table){
            $table->foreign('periode')->references('id')->on('periodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropForeign(['periode']);
        Schema::dropIfExists('devisis');
    }
};
