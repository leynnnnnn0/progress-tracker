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
        Schema::create('user_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_target_id')->constrained()->cascadeOnDelete();
            $table->integer('target_number')->nullable();
            $table->string('success_indicator')->nullable();
            $table->string('individual_accountable')->nullable();
            $table->string('actual_accomplishments')->nullable();
            $table->integer('actual_accomplishments_number')->nullable();
            $table->double('q')->nullable();
            $table->double('t')->nullable();
            $table->double('e')->nullable();
            $table->text('remark')->nullable();
            $table->string('link_to_evidence')->nullable();
            $table->string('pmt_remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tasks');
    }
};
