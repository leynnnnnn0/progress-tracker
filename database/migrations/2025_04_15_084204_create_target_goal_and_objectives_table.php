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
        Schema::create('target_goal_and_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained('targets')->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained('goals');
            $table->foreignId('objective_id')->constrained('objectives');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_goal_and_objectives');
    }
};
