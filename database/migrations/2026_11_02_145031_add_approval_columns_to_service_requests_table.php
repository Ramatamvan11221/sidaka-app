<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->foreignId('tu_approved_by')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->timestamp('tu_approved_at')->nullable()->after('tu_approved_by');
            
            $table->foreignId('kurikulum_approved_by')->nullable()->after('tu_approved_at')->constrained('users')->nullOnDelete();
            $table->timestamp('kurikulum_approved_at')->nullable()->after('kurikulum_approved_by');

            $table->text('rejection_note')->nullable()->after('kurikulum_approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['tu_approved_by']);
            $table->dropForeign(['kurikulum_approved_by']);
            $table->dropColumn([
                'tu_approved_by',
                'tu_approved_at',
                'kurikulum_approved_by',
                'kurikulum_approved_at',
                'rejection_note',
            ]);
        });
    }
};