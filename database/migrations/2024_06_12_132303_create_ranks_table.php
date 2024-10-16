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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode')->nullable();
            $table->unsignedBigInteger('devisi');
            $table->unsignedBigInteger('alternatif');
            $table->double('total')->default(0,00000); 
            $table->timestamps();
        });
        schema::table('ranks', function($table){
            $table->foreign('periode')->references('id')->on('periodes')->onDelete('cascade');
            $table->foreign('devisi')->references('id')->on('devisis')->onDelete('cascade');
            $table->foreign('alternatif')->references('id')->on('alternatifs')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropForeign(['alternatif']);
        Schema::dropForeign(['devisi']);
        Schema::dropForeign(['periode']); 
        Schema::dropIfExists('ranks'); 
    }
};
