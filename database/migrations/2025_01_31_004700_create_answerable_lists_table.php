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
        Schema::create('answerable_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_target_id')->constrained()->cascadeOnDelete();
            $table->string('success_indicators');
            $table->string('invididual_accountable');
            $table->integer('actual_accomplishments_number');
            $table->string('actual_accomplishments');
            $table->string('q');
            $table->string('t');
            $table->string('e');
            $table->string('remark');
            $table->string('link_to_evidence');
            $table->string('pmt_remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answerable_lists');
    }
};
