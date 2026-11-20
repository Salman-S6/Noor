<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة وتعميم الإشعارات وتحديثات التطبيق</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkbg: '#0b0f19',
                        darkcard: '#111827',
                        darkcard2: '#1e293b',
                        brand: {
                            50: '#fdf8f6',
                            100: '#f2e8e5',
                            500: '#b07a45',
                            600: '#7a4a2a',
                            700: '#5a361e',
                            800: '#3a2415',
                        }
                    },
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Dark Mode Initializer (Prevents FOUC) -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <!-- Google Fonts Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .glass-card {
            backdrop-filter: blur(12px);
        }
        .phone-frame {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-[#0b0f19] text-slate-800 dark:text-slate-100 min-h-screen flex flex-col transition-colors duration-200">

    <!-- شريط التنقل العلوي الفخم والموحد -->
    <header class="sticky top-0 z-40 bg-white/90 dark:bg-[#111827]/90 glass-card border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- شعار النظام والعنوان -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-600 to-cyan-700 text-white flex items-center justify-center text-2xl shadow-lg shadow-emerald-900/20 ring-4 ring-emerald-500/10">
                        <span>🔔</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-lg sm:text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                                إدارة وتعميم الإشعارات
                            </h1>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                Live Broadcast Hub
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">مركز إرسال التنبيهات والعروض وتحديثات APK للمستخدمين</p>
                    </div>
                </div>

                <!-- أزرار الإجراء والتبديل -->
                <div class="flex items-center gap-2.5">
                    
                    <!-- تبديل الوضع الليلي -->
                    <button id="theme-toggle" type="button" aria-label="تبديل الوضع الليلي" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition cursor-pointer">
                        <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                        <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    <!-- معاينة صفحة التطبيق الترحيبية -->
                    <a href="{{ url('/') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition">
                        <span>🌐</span>
                        <span>صفحة التطبيق</span>
                    </a>

                    <!-- زر التمرير السريع لنموذج الإنشاء -->
                    <a href="#createSection" class="px-4 py-2 rounded-xl text-xs font-extrabold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-900/20 transition flex items-center gap-1.5 cursor-pointer">
                        <span>✍️</span>
                        <span>إصدار إشعار جديد</span>
                    </a>
                </div>

            </div>

            <!-- تبويبات التنقل العلوية السريعة -->
            <div class="flex items-center gap-2 -mb-px pt-2 border-t border-slate-100 dark:border-slate-800 text-xs font-bold">
                <a href="{{ route('admin.notifications.index') }}" class="py-2.5 px-4 border-b-2 border-emerald-600 text-emerald-700 dark:text-emerald-400 bg-emerald-500/10 rounded-t-lg transition flex items-center gap-2">
                    <span>🔔</span>
                    <span>إدارة وتعميم الإشعارات</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-emerald-600 text-white font-mono">{{ $totalCount }}</span>
                </a>

                <a href="{{ route('admin.features.index') }}" class="py-2.5 px-4 border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/40 rounded-t-lg transition flex items-center gap-2">
                    <span>🎛️</span>
                    <span>التحكم بالواجهات والميزات</span>
                </a>
            </div>
        </div>
    </header>

    <!-- المحتوى الرئيسي -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- تنبيهات النجاح والأخطاء -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">✓</div>
                    <span class="text-sm font-bold text-emerald-900 dark:text-emerald-200">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 dark:text-emerald-400 font-bold text-lg hover:opacity-75 cursor-pointer">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 shadow-sm">
                <div class="flex items-center gap-2 font-bold text-rose-800 dark:text-rose-200 text-sm mb-2">
                    <span>⚠️</span>
                    <span>يرجى مراجعة وتصحيح الملاحظات التالية:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-rose-700 dark:text-rose-300 space-y-1 pr-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- بطاقات المؤشرات الرقمية (KPI Widgets) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            
            <!-- إجمالي الإشعارات -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي سجل الإشعارات والتعميمات</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-2">{{ $totalCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        📊
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-slate-500">
                    <span>موزعة بين تعميم عام وخاص</span>
                    <span class="font-bold text-emerald-600">سجل متزامن</span>
                </div>
            </div>

            <!-- الإشعارات النشطة -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400">الإشعارات النشطة حالياً بالتطبيق</p>
                        <p class="text-3xl font-black text-emerald-700 dark:text-emerald-400 mt-2">{{ $activeCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        ✅
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-emerald-600 font-bold">
                    <span>تظهر فوراً عند فتح التطبيق</span>
                    <span>{{ $totalCount > 0 ? round(($activeCount / $totalCount) * 100) : 0 }}% مفعل</span>
                </div>
            </div>

            <!-- إشعارات التحديثات -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400">إصدارات وتحديثات الـ APK</p>
                        <p class="text-3xl font-black text-indigo-700 dark:text-indigo-400 mt-2">{{ $updateCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        🚀
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-indigo-600 font-bold">
                    <span>تخضع لفحص النسخة الأحدث</span>
                    <span>APK Releases</span>
                </div>
            </div>

        </div>

        <!-- منطقة الاستوديو: نموذج الإنشاء + محاكي هاتف حي متزامن -->
        <div id="createSection" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- بطاقة نموذج إنشاء إشعار جديد (7 أعمدة) -->
            <div class="lg:col-span-7 bg-white dark:bg-[#111827] p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors space-y-6">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                            ✍️
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white">
                                إصدار إشعار أو تعميم جديد
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">قم بصياغة الإشعار واختيار الجمهور المستهدف ونوع التنبيه</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full">
                        New Broadcast
                    </span>
                </div>

                <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- اختيار الفئة المستهدفة -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-2">
                            الفئة المستهدفة من الإشعار <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex items-center justify-between p-3.5 rounded-2xl border cursor-pointer transition select-none bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-800 hover:border-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/40 dark:has-[:checked]:bg-emerald-950/30 has-[:checked]:ring-1 has-[:checked]:ring-emerald-500">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">🌐</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white">جميع المستخدمين</p>
                                        <p class="text-[10px] text-slate-500">تعميم عام لكافة التطبيق</p>
                                    </div>
                                </div>
                                <input type="radio" name="target_type" value="all" {{ old('target_type', 'all') == 'all' ? 'checked' : '' }} onchange="toggleTargetAudience(this.value)" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            </label>

                            <label class="relative flex items-center justify-between p-3.5 rounded-2xl border cursor-pointer transition select-none bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-800 hover:border-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/40 dark:has-[:checked]:bg-emerald-950/30 has-[:checked]:ring-1 has-[:checked]:ring-emerald-500">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">👤</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white">مستخدم محدد</p>
                                        <p class="text-[10px] text-slate-500">تاجر أو حساب معين</p>
                                    </div>
                                </div>
                                <input type="radio" name="target_type" value="specific" {{ old('target_type') == 'specific' ? 'checked' : '' }} onchange="toggleTargetAudience(this.value)" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            </label>
                        </div>
                    </div>

                    <!-- اختيار المستخدم في حال الاستهداف الخاص -->
                    <div id="user_select_container" class="{{ old('target_type') == 'specific' ? '' : 'hidden' }} space-y-1.5 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                        <label for="user_id" class="block text-xs font-extrabold text-slate-700 dark:text-slate-300">
                            اختر الحساب المستهدف <span class="text-rose-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                            <option value="">-- اضغط لاختيار المستخدم من القائمة --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    👤 {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-500">سيظهر هذا الإشعار في هاتف هذا المستخدم حصراً.</p>
                    </div>

                    <!-- نوع الإشعار -->
                    <div>
                        <label for="type" class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">
                            نوع وتصنيف الإشعار <span class="text-rose-500">*</span>
                        </label>
                        <select name="type" id="type" required onchange="handleTypeChange(this.value)" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                            <option value="update" {{ old('type', 'update') == 'update' ? 'selected' : '' }}>🚀 إشعار تحديث للتطبيق (App Update) - يظهر زر التحميل التلقائي</option>
                            <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>📢 إعلان عام للمستخدمين (General Broadcast)</option>
                            <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>ℹ️ معلومة وتنويه عام (Information)</option>
                            <option value="alert" {{ old('type') == 'alert' ? 'selected' : '' }}>⚠️ تنبيه عاجل أو صيانة (Urgent Alert)</option>
                            <option value="discount" {{ old('type') == 'discount' ? 'selected' : '' }}>🎁 عرض خاص أو خصم للمشتركين (Special Offer)</option>
                        </select>
                    </div>

                    <!-- عنوان الإشعار -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="title" class="block text-xs font-extrabold text-slate-700 dark:text-slate-300">
                                عنوان الإشعار <span class="text-rose-500">*</span>
                            </label>
                            <span id="titleCounter" class="text-[10px] text-slate-400">0 / 60</span>
                        </div>
                        <input type="text" name="title" id="title" required maxlength="100" value="{{ old('title') }}" oninput="updateLivePreview()" placeholder="مثال: يتوفر تحديث أمني جديد للتطبيق v1.0.1" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400">
                    </div>

                    <!-- نص ومحتوى الإشعار -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="body" class="block text-xs font-extrabold text-slate-700 dark:text-slate-300">
                                تفاصيل ومحتوى الإشعار <span class="text-rose-500">*</span>
                            </label>
                            <span id="bodyCounter" class="text-[10px] text-slate-400">0 / 250</span>
                        </div>
                        <textarea name="body" id="body" rows="3" required maxlength="1000" oninput="updateLivePreview()" placeholder="أدخل تفاصيل التحديث أو محتوى التنبيه الذي سيقرأه المستخدم في هاتفه..." class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 leading-relaxed">{{ old('body') }}</textarea>
                    </div>

                    <!-- صندوق تفاصيل التحديث APK (يظهر عند اختيار تحديث) -->
                    <div id="updateFieldsContainer" class="p-4 sm:p-5 rounded-2xl bg-amber-500/5 border border-amber-500/20 space-y-4">
                        
                        <!-- تنبيه النسخة الحالية لمطور التطبيق -->
                        <div class="p-3.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-900 dark:text-amber-300 text-xs leading-relaxed flex items-start gap-3">
                            <span class="text-xl shrink-0">⚠️</span>
                            <div>
                                <p class="font-extrabold">تنبيه حاسم من مطور التطبيق (النسخة الحالية المثبتة: 1.0.0):</p>
                                <p class="text-[11px] mt-0.5 text-amber-800 dark:text-amber-300/90">
                                    لا تنشر أي رقم إصدار أكبر من النسخة التي تم بناؤها وتسليمها فعلياً، وإلا سيُقفل التطبيق لدى جميع المستخدمين لإجبارهم على التحديث.
                                </p>
                            </div>
                        </div>

                        <!-- رقم الإصدار والرابط -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="version" class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">
                                    رقم الإصدار (Version) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="version" id="version" value="{{ old('version') }}" oninput="updateLivePreview()" placeholder="مثال: 1.0.1 أو 2.0.0" pattern="^\d+\.\d+\.\d+$" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400">
                                <p class="text-[10px] text-slate-500 mt-1">صيغة x.y.z فقط بدون حرف v أو بادئات.</p>
                            </div>

                            <div>
                                <label for="link" class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">
                                    رابط تحميل ملف الـ APK المباشر <span class="text-rose-500">*</span>
                                </label>
                                <input type="url" name="link" id="link" value="{{ old('link') }}" placeholder="https://domain.com/downloads/noor.apk" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-left font-mono" dir="ltr">
                                <p class="text-[10px] text-slate-500 mt-1">رابط مباشر للملف بصيغة https:// حصراً.</p>
                            </div>
                        </div>

                        <!-- خيار التحديث الإجباري -->
                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_mandatory" id="is_mandatory" value="1" {{ old('is_mandatory') ? 'checked' : '' }} class="w-4 h-4 text-rose-600 rounded border-slate-300 dark:border-slate-700 focus:ring-rose-500 cursor-pointer">
                            <label for="is_mandatory" class="text-xs font-bold text-slate-800 dark:text-slate-200 cursor-pointer">
                                فرض التحديث بشكل إجباري (يمنع استخدام التطبيق نهائياً حتى يتم التحديث)
                            </label>
                        </div>
                    </div>

                    <!-- التفعيل المباشر -->
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl">⚡</span>
                            <div>
                                <p class="text-xs font-bold text-slate-900 dark:text-white">نشر وتفعيل الإشعار فوراً</p>
                                <p class="text-[10px] text-slate-500">سيكون مرئياً فور الحفظ لطلبات الـ API</p>
                            </div>
                        </div>
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-4 h-4 text-emerald-600 rounded border-slate-300 dark:border-slate-700 focus:ring-emerald-500 cursor-pointer">
                    </div>

                    <!-- زر الإرسال -->
                    <button type="submit" class="w-full py-3.5 px-6 rounded-2xl text-xs font-extrabold text-white bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 hover:from-emerald-700 hover:to-teal-800 shadow-lg shadow-emerald-900/20 transition duration-150 flex items-center justify-center gap-2 cursor-pointer">
                        <span class="text-base">🚀</span>
                        <span class="text-sm">إرسال ونشر الإشعار</span>
                    </button>
                </form>
            </div>

            <!-- بطاقة محاكي الهاتف الحي (5 أعمدة) -->
            <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-28">
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-base">📱</span>
                        <span class="text-xs font-extrabold text-slate-700 dark:text-slate-300">المعاينة الحية لهاتف المستخدم</span>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-500/10 px-2.5 py-0.5 rounded-full">
                        Live Preview
                    </span>
                </div>

                <!-- إطار الهاتف الذكي التفاعلي -->
                <div class="phone-frame bg-[#1f2937] dark:bg-[#030712] rounded-[36px] p-4 border-4 border-slate-700/60 dark:border-slate-800 text-white relative overflow-hidden">
                    
                    <!-- نوتش الهاتف العلوي والساعة -->
                    <div class="flex items-center justify-between px-3 py-1 text-[11px] text-slate-400 font-mono mb-6">
                        <span>{{ date('H:i') }}</span>
                        <div class="w-16 h-4 bg-slate-800 rounded-full mx-auto"></div>
                        <div class="flex items-center gap-1.5">
                            <span>5G</span>
                            <span>100%</span>
                        </div>
                    </div>

                    <!-- واجهة قفل الشاشة مع إشعار تفاعلي ينبض بالحياة -->
                    <div class="space-y-3">
                        <div class="text-center py-4">
                            <p class="text-2xl font-light tracking-wide text-slate-200">{{ date('H:i') }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ date('l, d F') }}</p>
                        </div>

                        <!-- كرت الإشعار التفاعلي داخل الهاتف -->
                        <div class="p-3.5 rounded-2xl bg-white/95 text-slate-900 shadow-xl backdrop-blur-md border border-white/20 transition-all duration-200">
                            <div class="flex items-start gap-3">
                                <div id="previewIconBox" class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg shadow shrink-0">
                                    <span id="previewEmoji">🚀</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs font-black text-slate-900">تطبيق نور</span>
                                            <span id="previewBadge" class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-800">
                                                تحديث
                                            </span>
                                        </div>
                                        <span class="text-[10px] text-slate-400">الآن</span>
                                    </div>
                                    <h4 id="previewTitle" class="text-xs font-bold text-slate-900 mt-1 truncate">
                                        يتوفر تحديث جديد للتطبيق
                                    </h4>
                                    <p id="previewBody" class="text-[11px] text-slate-600 mt-0.5 leading-relaxed line-clamp-3">
                                        أدخل عنوان ومحتوى الإشعار في النموذج المقابل لتشاهد المعاينة فوراً كما ستصل لهواتف العملاء.
                                    </p>
                                    <div id="previewUpdateDetails" class="mt-2.5 pt-2 border-t border-slate-100 flex items-center justify-between text-[10px]">
                                        <span id="previewVersion" class="font-mono font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">
                                            v1.0.0
                                        </span>
                                        <span class="font-bold text-emerald-600 flex items-center gap-1">
                                            <span>📥</span> تنزيل APK
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- إشعار تجريبي إضافي خفيف للواقعية -->
                        <div class="p-3 rounded-xl bg-white/10 text-slate-300 text-[10px] flex items-center justify-between">
                            <span>🔐 نظام الحماية ومزامنة البيانات يعمل</span>
                            <span>منذ ساعة</span>
                        </div>
                    </div>

                    <!-- الخط السفلي للهاتف -->
                    <div class="w-24 h-1 bg-slate-600/60 rounded-full mx-auto mt-8 mb-1"></div>
                </div>

                <!-- بطاقة الملاحظات الفنية للمدير -->
                <div class="p-4 rounded-2xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 text-xs space-y-2">
                    <div class="flex items-center gap-2 font-bold text-slate-800 dark:text-slate-200">
                        <span>💡</span>
                        <span>معايير إرسال الإشعارات الناجحة:</span>
                    </div>
                    <ul class="text-[11px] text-slate-500 dark:text-slate-400 space-y-1 list-disc list-inside pr-1">
                        <li>العناوين القصيرة (أقل من 40 حرفاً) تحقق أعلى نسبة قراءة.</li>
                        <li>إشعار التحديث يوجه المستخدم مباشرة لملف التحميل.</li>
                        <li>يمكنك إيقاف أي إشعار منشور بنقرة واحدة من جدول السجل أدناه.</li>
                    </ul>
                </div>

            </div>

        </div>

        <!-- جدول سجل الإشعارات والتعميمات السابقة -->
        <div class="bg-white dark:bg-[#111827] rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
            
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center text-xl">
                        📋
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 dark:text-white">
                            سجل الإشعارات المرسلة
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">تتبع حالة كل تعميم وتاريخ نشره مع إمكانية التفعيل أو الحذف</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700">
                        {{ $notifications->total() }} إشعار مسجل
                    </span>
                </div>
            </div>

            @if($notifications->isEmpty())
                <div class="p-16 text-center text-slate-400 dark:text-slate-500">
                    <div class="text-5xl mb-3">📭</div>
                    <p class="text-base font-bold text-slate-700 dark:text-slate-300">لم يتم إنشاء أي إشعارات بعد</p>
                    <p class="text-xs mt-1 text-slate-500 max-w-sm mx-auto">استخدم الاستوديو أعلاه لصياغة أول تعميم أو تنبيه لمستخدمي تطبيق نور.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-extrabold border-b border-slate-200/80 dark:border-slate-800">
                            <tr>
                                <th class="p-4">نوع الإشعار</th>
                                <th class="p-4">المستهدف</th>
                                <th class="p-4">العنوان ومحتوى الإشعار</th>
                                <th class="p-4">الحالة</th>
                                <th class="p-4">تاريخ النشر</th>
                                <th class="p-4 text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($notifications as $item)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    
                                    <!-- نوع الإشعار -->
                                    <td class="p-4 whitespace-nowrap">
                                        @if($item->type === 'update')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                                <span>🚀</span> تحديث
                                            </span>
                                        @elseif($item->type === 'alert')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                                <span>⚠️</span> تنبيه عاجل
                                            </span>
                                        @elseif($item->type === 'discount')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-pink-50 dark:bg-pink-950/60 text-pink-700 dark:text-pink-300 border border-pink-200 dark:border-pink-800">
                                                <span>🎁</span> عرض / خصم
                                            </span>
                                        @elseif($item->type === 'info')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                <span>ℹ️</span> معلومة
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                <span>📢</span> عام
                                            </span>
                                        @endif
                                    </td>

                                    <!-- المستهدف -->
                                    <td class="p-4 whitespace-nowrap">
                                        @if($item->user)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-xs font-bold bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-sky-800" title="{{ $item->user->email }}">
                                                <span>👤</span> {{ $item->user->name }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                                <span>🌐</span> للجميع
                                            </span>
                                        @endif
                                    </td>

                                    <!-- العنوان والتفاصيل -->
                                    <td class="p-4 min-w-[280px]">
                                        <p class="font-extrabold text-slate-900 dark:text-white text-sm">{{ $item->title }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $item->body }}</p>
                                        
                                        @if($item->version || $item->link)
                                            <div class="flex flex-wrap items-center gap-2 mt-2.5">
                                                @if($item->version)
                                                    <span class="text-[10px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-700">
                                                        إصدار: {{ $item->version }}
                                                    </span>
                                                @endif
                                                @if($item->link)
                                                    <a href="{{ $item->link }}" target="_blank" class="text-[10px] text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 font-bold">
                                                        <span>🔗</span> رابط التحميل
                                                    </a>
                                                @endif
                                                @if($item->is_mandatory)
                                                    <span class="text-[10px] bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 font-bold px-2 py-0.5 rounded-md border border-rose-200 dark:border-rose-800">
                                                        إجباري
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>

                                    <!-- الحالة -->
                                    <td class="p-4 whitespace-nowrap">
                                        @if($item->is_active)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                نشط
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                معطل
                                            </span>
                                        @endif
                                    </td>

                                    <!-- تاريخ النشر بالوقت العربي -->
                                    <td class="p-4 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                        <div class="font-bold text-slate-700 dark:text-slate-300">{{ $item->created_at->format('Y-m-d') }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $item->created_at->format('H:i') }}</div>
                                        <span class="block text-[11px] text-emerald-600 dark:text-emerald-400 font-bold mt-0.5">
                                            {{ $item->created_at->locale('ar')->diffForHumans() }}
                                        </span>
                                    </td>

                                    <!-- أزرار الإجراءات -->
                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- زر تبديل الحالة -->
                                            <form action="{{ route('admin.notifications.toggle', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="{{ $item->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}" class="text-xs px-3 py-1.5 rounded-xl border {{ $item->is_active ? 'border-amber-300 dark:border-amber-500/40 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-950/30' : 'border-emerald-300 dark:border-emerald-500/40 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30' }} font-bold transition cursor-pointer">
                                                    {{ $item->is_active ? 'إيقاف' : 'تفعيل' }}
                                                </button>
                                            </form>

                                            <!-- زر الحذف -->
                                            <form action="{{ route('admin.notifications.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإشعار نهائياً من السجل؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="حذف" class="text-xs px-3 py-1.5 rounded-xl border border-rose-200 dark:border-rose-500/40 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 font-bold transition cursor-pointer">
                                                    حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($notifications->hasPages())
                    <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @endif

        </div>

    </main>

    <!-- تذييل الصفحة الموحد -->
    <footer class="bg-white dark:bg-[#111827] border-t border-slate-200/80 dark:border-slate-800 py-6 mt-auto transition-colors">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-500 dark:text-slate-400">
            لوحة تحكم تطبيق نـور &copy; {{ date('Y') }} • نظام إدارة وتعميم الإشعارات وتحديثات التطبيق
        </div>
    </footer>

    <!-- سكريبت التفاعل والمحاكي والوضع المظلم -->
    <script>
        // إظهار وإخفاء قائمة المستخدمين
        function toggleTargetAudience(targetType) {
            const container = document.getElementById('user_select_container');
            const select = document.getElementById('user_id');
            if (targetType === 'specific') {
                container.classList.remove('hidden');
                select.setAttribute('required', 'required');
            } else {
                container.classList.add('hidden');
                select.removeAttribute('required');
                select.value = '';
            }
        }

        // إظهار وإخفاء حقول التحديث وتحديث شارة المحاكي
        function handleTypeChange(type) {
            const updateContainer = document.getElementById('updateFieldsContainer');
            const previewBadge = document.getElementById('previewBadge');
            const previewIconBox = document.getElementById('previewIconBox');
            const previewEmoji = document.getElementById('previewEmoji');
            const previewUpdateDetails = document.getElementById('previewUpdateDetails');

            if (type === 'update') {
                updateContainer.classList.remove('hidden');
                previewBadge.textContent = 'تحديث';
                previewBadge.className = 'text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-800';
                previewIconBox.className = 'w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg shadow shrink-0';
                previewEmoji.textContent = '🚀';
                previewUpdateDetails.style.display = 'flex';
            } else if (type === 'alert') {
                updateContainer.classList.add('hidden');
                previewBadge.textContent = 'تنبيه عاجل';
                previewBadge.className = 'text-[9px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-800';
                previewIconBox.className = 'w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-lg shadow shrink-0';
                previewEmoji.textContent = '⚠️';
                previewUpdateDetails.style.display = 'none';
            } else if (type === 'discount') {
                updateContainer.classList.add('hidden');
                previewBadge.textContent = 'عرض خاص';
                previewBadge.className = 'text-[9px] font-bold px-1.5 py-0.5 rounded bg-pink-100 text-pink-800';
                previewIconBox.className = 'w-9 h-9 rounded-xl bg-pink-600 text-white flex items-center justify-center text-lg shadow shrink-0';
                previewEmoji.textContent = '🎁';
                previewUpdateDetails.style.display = 'none';
            } else if (type === 'info') {
                updateContainer.classList.add('hidden');
                previewBadge.textContent = 'تنويه';
                previewBadge.className = 'text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-800';
                previewIconBox.className = 'w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg shadow shrink-0';
                previewEmoji.textContent = 'ℹ️';
                previewUpdateDetails.style.display = 'none';
            } else {
                updateContainer.classList.add('hidden');
                previewBadge.textContent = 'إعلان عام';
                previewBadge.className = 'text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800';
                previewIconBox.className = 'w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg shadow shrink-0';
                previewEmoji.textContent = '📢';
                previewUpdateDetails.style.display = 'none';
            }
        }

        // تحديث المعاينة الحية فور الكتابة
        function updateLivePreview() {
            const titleInput = document.getElementById('title');
            const bodyInput = document.getElementById('body');
            const versionInput = document.getElementById('version');

            const previewTitle = document.getElementById('previewTitle');
            const previewBody = document.getElementById('previewBody');
            const previewVersion = document.getElementById('previewVersion');

            const titleCounter = document.getElementById('titleCounter');
            const bodyCounter = document.getElementById('bodyCounter');

            // عدادات الحروف
            titleCounter.textContent = titleInput.value.length + ' / 60';
            bodyCounter.textContent = bodyInput.value.length + ' / 250';

            // العنوان
            if (titleInput.value.trim() !== '') {
                previewTitle.textContent = titleInput.value;
            } else {
                previewTitle.textContent = 'يتوفر تحديث جديد للتطبيق';
            }

            // النص
            if (bodyInput.value.trim() !== '') {
                previewBody.textContent = bodyInput.value;
            } else {
                previewBody.textContent = 'أدخل عنوان ومحتوى الإشعار في النموذج المقابل لتشاهد المعاينة فوراً كما ستصل لهواتف العملاء.';
            }

            // الإصدار
            if (versionInput && versionInput.value.trim() !== '') {
                previewVersion.textContent = 'v' + versionInput.value;
            } else {
                previewVersion.textContent = 'v1.0.0';
            }
        }

        // تهيئة الحالة الأولية للنوع
        document.addEventListener('DOMContentLoaded', function() {
            handleTypeChange(document.getElementById('type').value);
            updateLivePreview();
        });

        // الوضع المظلم
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        function updateThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }
        }

        updateThemeUI();

        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateThemeUI();
        });
    </script>
</body>
</html>