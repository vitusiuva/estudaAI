<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            if (!Schema::hasColumn('topics', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->constrained('topics')->onDelete('cascade')->after('discipline_id');
            }
            if (!Schema::hasColumn('topics', 'is_completed')) {
                $table->boolean('is_completed')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn(['parent_id', 'is_completed']);
        });
    }
};
