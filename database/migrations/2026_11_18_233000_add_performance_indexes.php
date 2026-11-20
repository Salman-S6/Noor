<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->index('date');
            $table->index('invoice_number');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('date');
            $table->index(['customer_id', 'date']);
        });

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->index(['type', 'is_active']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['invoice_number']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['customer_id', 'date']);
        });

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->dropIndex(['type', 'is_active']);
            $table->dropIndex(['created_at']);
        });
    }
};
