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
        Schema::create('kriterianbs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devisi');  
            $table->unsignedBigInteger('id1');
            $table->unsignedBigInteger('id2');
            $table->float('nilai')->default(1.00000); 
            $table->timestamps();        
        });
        schema::table('kriterianbs', function($table){
            $table->foreign('devisi')->references('id')->on('devisis')->onDelete('cascade'); 
            $table->foreign('id1')->references('id')->on('kriterias')->onDelete('cascade');
            $table->foreign('id2')->references('id')->on('kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterianbs');
        Schema::dropForeign(['devisi']);
        Schema::dropForeign(['kriteria']); 
    }
};
