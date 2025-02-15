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
            $table->foreignId('users_offices_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_target_id')->constrained()->cascadeOnDelete();
            $table->integer('target_number')->default(0);
            $table->string('success_indicator')->nullable();
            $table->string('individual_accountable')->nullable();
            $table->integer('actual_accomplishments_number')->default(0);
            $table->double('q')->default(0);
            $table->double('t')->default(0);
            $table->double('e')->default(0);
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
