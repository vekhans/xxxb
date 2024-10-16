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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kriteria');
            $table->float('nilai1')->default(0.00000);
            $table->float('nilai2')->default(0.00000);
            $table->integer('bobot')->default(0);
            $table->timestamps();
        });
        schema::table('nilais', function($table){
            $table->foreign('kriteria')->references('id')->on('kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
        Schema::dropForeign(['kriteria']);
    }
};
