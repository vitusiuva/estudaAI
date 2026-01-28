<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('discipline_id')->constrained()->onDelete('cascade');
            $table->integer('weight')->default(1);
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('wrong_answers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_exam_results');
    }
};
