<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_features', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->string('action_type')->default('lock'); // 'lock' أو 'hide'
            $table->string('disabled_message')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // إدراج الواجهات الأساسية للتطبيق بشكل افتراضي
        $defaultFeatures = [
            [
                'key' => 'reports_summary',
                'name' => 'الإحصائيات والتقارير العامة',
                'description' => 'شاشة الرسوم البيانية، الملخص المالي، وأعلى المدينين في التطبيق.',
                'icon' => '📊',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'قسم الإحصائيات قيد التحديث وسيعود للعمل قريباً.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'overdue_debts',
                'name' => 'الديون المتأخرة',
                'description' => 'شاشة متابعة الزبائن المتأخرين في السداد وحساب فترات التأخير.',
                'icon' => '⚠️',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'شاشة الديون المتأخرة معطلة مؤقتاً لأعمال الصيانة.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'customers_summary',
                'name' => 'كشف حساب الزبائن والديون',
                'description' => 'جدول كشف حساب الزبائن الإجمالي (الفواتير، الدفعات، الأرصدة) والطباعة.',
                'icon' => '📋',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'شاشة كشف الزبائن قيد التحديث حالياً.',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'customers_management',
                'name' => 'دليل وإدارة الزبائن',
                'description' => 'شاشة استعراض الزبائن والبحث وإضافة وتعديل بياناتهم.',
                'icon' => '👥',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'إدارة الزبائن غير متاحة مؤقتاً.',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'invoices',
                'name' => 'الفواتير والمبيعات',
                'description' => 'شاشة استعراض فواتير الزبون وإصدار وتعديل وحذف الفواتير.',
                'icon' => '🧾',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'قسم الفواتير معطل مؤقتاً.',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'invoice_items',
                'name' => 'تفاصيل وبنود الفواتير',
                'description' => 'إتاحة إدخال وتفقيط بنود الفاتورة التفصيلية (الوصف، الكمية، سعر الوحدة، الإجمالي) وعرضها.',
                'icon' => '📑',
                'is_enabled' => true,
                'action_type' => 'hide',
                'disabled_message' => 'ميزة تفاصيل وبنود الفواتير غير متاحة حالياً.',
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'payments',
                'name' => 'سندات القبض والدفعات',
                'description' => 'شاشة تسجيل دفعات ومقبوضات الزبائن وإيصالات السداد.',
                'icon' => '💵',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'تسجيل الدفعات معطل مؤقتاً للصيانة.',
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'account_movement',
                'name' => 'حركة الحسابات',
                'description' => 'شاشة كشف الحركة التفصيلي للفواتير والدفعات مع الفلترة بالتواريخ.',
                'icon' => '📈',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'شاشة كشف الحركة غير متاحة حالياً.',
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'notifications',
                'name' => 'صندوق الإشعارات',
                'description' => 'شاشة استعراض الإشعارات والتنبيهات والعروض وتحديثات النظام.',
                'icon' => '🔔',
                'is_enabled' => true,
                'action_type' => 'hide',
                'disabled_message' => 'صندوق الإشعارات معطل مؤقتاً.',
                'sort_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'change_password',
                'name' => 'تغيير كلمة المرور',
                'description' => 'ميزة تحديث كلمة المرور لحساب المستخدم من داخل التطبيق.',
                'icon' => '🔐',
                'is_enabled' => true,
                'action_type' => 'lock',
                'disabled_message' => 'ميزة تغيير كلمة المرور معطلة حالياً، يرجى التواصل مع الإدارة.',
                'sort_order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('app_features')->insert($defaultFeatures);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_features');
    }
};
