<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discipline_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_studied')->default(false);
            $table->boolean('is_revised_1x')->default(false);
            $table->boolean('is_revised_2x')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
