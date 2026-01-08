<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->date('scheduled_date');
            $table->enum('status', ['pendente', 'concluida', 'atrasada', 'ignorada'])->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
