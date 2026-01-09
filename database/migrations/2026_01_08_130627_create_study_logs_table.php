<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['teoria', 'questoes', 'revisao', 'videoaula', 'pdf']);
            $table->integer('duration_minutes');
            $table->integer('questions_correct')->default(0);
            $table->integer('questions_total')->default(0);
            $table->integer('pages_read')->default(0);
            $table->text('comments')->nullable();
            $table->timestamp('studied_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_logs');
    }
};
