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
        Schema::create('area__graduate', function (Blueprint $table) {
            
           //$table->timestamps();

           
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('graduate_id')->constrained()->cascadeOnDelete();
            

             $table->primary(['area_id', 'graduate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area__graduate');
    }
};
