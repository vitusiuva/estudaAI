<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('revisions', function (Blueprint $table) {
            if (!Schema::hasColumn('revisions', 'interval_days')) {
                $table->integer('interval_days')->default(1);
            }
        });
    }

    public function down(): void
    {
        Schema::table('revisions', function (Blueprint $table) {
            $table->dropColumn('interval_days');
        });
    }
};
