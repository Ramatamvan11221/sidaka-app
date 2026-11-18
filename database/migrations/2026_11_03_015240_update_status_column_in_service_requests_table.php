<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('status', 50)->default('pending_tu')->change();
        });

        Schema::table('request_status_histories', function (Blueprint $table) {
            $table->string('status', 50)->default('pending_tu')->change();
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('status', 255)->default('pending')->change();
        });

        Schema::table('request_status_histories', function (Blueprint $table) {
            $table->string('status', 255)->default('pending')->change();
        });
    }
};