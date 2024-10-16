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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id(); 
            $table->string('kode');
            $table->string('nama');
            $table->unsignedBigInteger('devisi'); 
            $table->enum('atribut',['Benefit','Cost'])->default('Benefit');
            $table->timestamps();
        });
        schema::table('kriterias', function($table){
            $table->foreign('devisi')->references('id')->on('devisis')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
        Schema::dropForeign(['devisi']); 
    }
};
