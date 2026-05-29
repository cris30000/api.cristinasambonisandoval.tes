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
        Schema::create('title__graduate', function (Blueprint $table) {
            
           // $table->timestamps();

            $table->foreignId('title_id')->constrained()->cascadeOnDelete();
            $table->foreignId('graduate_id')->constrained()->cascadeOnDelete();
            

             $table->primary(['title_id', 'graduate_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('title__graduate');
    }
};
