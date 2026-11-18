<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_request_items', function (Blueprint $table) {
            // Lepas foreign key lama
            $table->dropForeign(['document_id']);

            // Pasang foreign key baru dengan aturan CASCADE
            $table->foreign('document_id')
                  ->references('id')
                  ->on('documents')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('service_request_items', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->foreign('document_id')
                  ->references('id')
                  ->on('documents');
        });
    }
};