<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('exam_type')->nullable(); // Múltipla Escolha, Certo/Errado
            $table->string('exam_board')->nullable(); // FCC, CESPE, etc.
            $table->date('date');
            $table->integer('duration_minutes')->nullable();
            $table->decimal('total_score', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_exams');
    }
};
