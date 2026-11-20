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
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('type')->default('general'); // 'update', 'general', 'alert'
            $table->string('link')->nullable(); // رابط التحديث أو التحميل
            $table->string('version')->nullable(); // رقم الإصدار في حال كان تحديث
            $table->boolean('is_mandatory')->default(false); // هل التحديث إجباري
            $table->boolean('is_active')->default(true); // تفعيل أو إيقاف الإشعار
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
    }
};
