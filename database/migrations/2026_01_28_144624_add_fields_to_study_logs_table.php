<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('study_logs', 'pages_read')) {
                $table->integer('pages_read')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('study_logs', function (Blueprint $table) {
            $table->dropColumn('pages_read');
        });
    }
};
