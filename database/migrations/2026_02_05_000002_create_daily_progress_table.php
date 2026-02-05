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
        Schema::create('daily_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->bigInteger('income')->default(0);
            $table->text('achievement')->nullable();
            $table->text('lesson_learned')->nullable();
            $table->text('improvement_plan')->nullable();
            $table->timestamps();

            // Unique constraint: one entry per date per target
            $table->unique(['target_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_progress');
    }
};
