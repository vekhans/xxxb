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
        Schema::create('alternatifs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');  
            $table->unsignedBigInteger('periode');  
            $table->double('total')->default(0,00000);  
            $table->timestamps();          
        });
        schema::table('alternatifs', function($table){             
            $table->foreign('periode')->references('id')->on('periodes')->onDelete('cascade'); 
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatifs');  
        Schema::dropForeign(['periode']);
    }
};
