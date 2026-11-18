<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->foreignId('class_id')
                  ->nullable()
                  ->after('nip')
                  ->constrained('classes')
                  ->nullOnDelete();

            $table->foreignId('major_id')
                  ->nullable()
                  ->after('class_id')
                  ->constrained('majors')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['major_id']);
            $table->dropColumn(['class_id', 'major_id']);
        });
    }
};