<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - نظام التحكم بواجهات وميزات التطبيق</title>
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
        /* Toggle Switch Animation */
        .toggle-checkbox:checked {
            right: 1.5rem;
            border-color: #10b981;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #10b981;
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-[#0b0f19] text-slate-800 dark:text-slate-100 min-h-screen flex flex-col transition-colors duration-200">

    <!-- شريط التنقل العلوي الفخم -->
    <header class="sticky top-0 z-40 bg-white/90 dark:bg-[#111827]/90 glass-card border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- شعار النظام والعنوان -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 via-brand-600 to-amber-700 text-white flex items-center justify-center text-2xl shadow-lg shadow-amber-900/20 ring-4 ring-amber-500/10">
                        <span>🎛️</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-lg sm:text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                                نظام التحكم بواجهات وميزات التطبيق
                            </h1>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                Feature Flags Live
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">لوحة التحكم المركزية لتشغيل وتعطيل أقسام تطبيق نور بدون رفع تحديث</p>
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

                    <!-- معاينة الموقع الرئيسي -->
                    <a href="{{ url('/') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition">
                        <span>🌐</span>
                        <span>صفحة التطبيق</span>
                    </a>

                    <!-- زر إضافة واجهة جديدة -->
                    <button onclick="document.getElementById('newFeatureModal').classList.remove('hidden')" class="px-4 py-2 rounded-xl text-xs font-extrabold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-900/20 transition flex items-center gap-1.5 cursor-pointer">
                        <span>➕</span>
                        <span>إضافة واجهة</span>
                    </button>
                </div>

            </div>

            <!-- تبويبات التنقل العلوية السريعة -->
            <div class="flex items-center gap-2 -mb-px pt-2 border-t border-slate-100 dark:border-slate-800 text-xs font-bold">
                <a href="{{ route('admin.features.index') }}" class="py-2.5 px-4 border-b-2 border-amber-600 text-amber-700 dark:text-amber-400 bg-amber-500/10 rounded-t-lg transition flex items-center gap-2">
                    <span>🎛️</span>
                    <span>التحكم بالواجهات</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-amber-600 text-white font-mono">{{ $totalCount }}</span>
                </a>

                <a href="{{ route('admin.notifications.index') }}" class="py-2.5 px-4 border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/40 rounded-t-lg transition flex items-center gap-2">
                    <span>🔔</span>
                    <span>إدارة وتعميم الإشعارات</span>
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
            
            <!-- إجمالي الواجهات -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي شاشات التطبيق المُدارة</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-2">{{ $totalCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        📱
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-slate-500">
                    <span>تخضع لتحكم الـ API المباشر</span>
                    <span class="font-bold text-emerald-600">100% جاهزة</span>
                </div>
            </div>

            <!-- الواجهات المفعلة -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400">واجهات نشطة ومتاحة للمستخدمين</p>
                        <p class="text-3xl font-black text-emerald-700 dark:text-emerald-400 mt-2">{{ $enabledCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        ✅
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-emerald-600 font-bold">
                    <span>تعمل بصورة طبيعية في التطبيق</span>
                    <span>{{ $totalCount > 0 ? round(($enabledCount / $totalCount) * 100) : 0 }}%</span>
                </div>
            </div>

            <!-- الواجهات المعطلة -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400">واجهات موقوفة (مقفلة أو مخفية)</p>
                        <p class="text-3xl font-black text-rose-700 dark:text-rose-400 mt-2">{{ $disabledCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        ⛔
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-rose-600 font-bold">
                    <span>محظورة من العرض أو الاستخدام</span>
                    <span>{{ $disabledCount }} شاشات</span>
                </div>
            </div>

        </div>

        <!-- شريط البحث والفلترة السريعة -->
        <div class="p-4 rounded-2xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <!-- حقل البحث اللحظي -->
            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    🔍
                </span>
                <input type="text" id="featureSearchInput" onkeyup="filterFeatures()" placeholder="بحث بالاسم أو المعرّف التقني..." class="w-full pr-10 pl-4 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <!-- أزرار الفلترة السريعة (الكل / مفعل / معطل) -->
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 text-xs font-bold">
                <button type="button" onclick="setFilter('all')" id="filter-all" class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm transition">
                    الكل ({{ $totalCount }})
                </button>
                <button type="button" onclick="setFilter('enabled')" id="filter-enabled" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">
                    المفعلة فقط ({{ $enabledCount }})
                </button>
                <button type="button" onclick="setFilter('disabled')" id="filter-disabled" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">
                    المعطلة فقط ({{ $disabledCount }})
                </button>
            </div>

        </div>

        <!-- بطاقات ميزات التطبيق (Feature Cards Grid) -->
        <div id="featuresGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($features as $feature)
                <div class="feature-item p-6 rounded-3xl bg-white dark:bg-[#111827] border {{ $feature->is_enabled ? 'border-slate-200/90 dark:border-slate-800' : 'border-rose-200 dark:border-rose-950/80 ring-1 ring-rose-500/20' }} shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between"
                     data-key="{{ strtolower($feature->key) }}"
                     data-name="{{ strtolower($feature->name) }}"
                     data-status="{{ $feature->is_enabled ? 'enabled' : 'disabled' }}">
                    
                    <div class="space-y-4">
                        
                        <!-- الهيدر الداخلي للبطاقة -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-inner {{ $feature->is_enabled ? 'bg-amber-50 dark:bg-amber-950/40 text-amber-900 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50' : 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/50' }}">
                                    {{ $feature->icon ?: '📱' }}
                                </div>
                                <div>
                                    <h2 class="text-base font-extrabold text-slate-900 dark:text-white leading-tight">
                                        {{ $feature->name }}
                                    </h2>
                                    <span class="inline-block text-[11px] font-mono text-slate-400 dark:text-slate-500 mt-0.5 bg-slate-100 dark:bg-slate-800/80 px-2 py-0.5 rounded-md">
                                        {{ $feature->key }}
                                    </span>
                                </div>
                            </div>

                            <!-- حالة التفعيل والزر السريع -->
                            <form action="{{ route('admin.features.toggle', $feature->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="{{ $feature->is_enabled ? 'انقر للتعطيل' : 'انقر للتشغيل' }}" class="group relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $feature->is_enabled ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-700' }}">
                                    <span class="sr-only">تبديل الحالة</span>
                                    <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-md ring-0 transition duration-200 ease-in-out {{ $feature->is_enabled ? '-translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </form>
                        </div>

                        <!-- وصف الشاشة -->
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed min-h-[36px]">
                            {{ $feature->description ?: 'تتحكم هذه الميزة في إتاحة هذه الشاشة للمستخدمين بالتطبيق.' }}
                        </p>

                        <!-- تفاصيل التعطيل والإجراء -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800/80 space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 dark:text-slate-400 font-semibold">إجراء الإيقاف:</span>
                                @if($feature->action_type === 'hide')
                                    <span class="inline-flex items-center gap-1 font-extrabold px-2 py-0.5 rounded-md bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        <span>👁️</span>
                                        <span>إخفاء كلي من القائمة</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 font-extrabold px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                        <span>🔒</span>
                                        <span>قفل مع رسالة تنبيه</span>
                                    </span>
                                @endif
                            </div>

                            @if($feature->disabled_message)
                                <div class="pt-1.5 border-t border-slate-200/60 dark:border-slate-800">
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block">نص رسالة التنبيه:</span>
                                    <p class="text-slate-700 dark:text-slate-300 font-medium italic text-[11px] mt-0.5 line-clamp-2">
                                        "{{ $feature->disabled_message }}"
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- أزرار الإجراء في أسفل البطاقة -->
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-[11px] font-bold {{ $feature->is_enabled ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ $feature->is_enabled ? '● مفعلة حالياً بالتطبيق' : '○ معطلة ومحجوبة حالياً' }}
                        </span>

                        <button type="button" onclick="openEditModal({{ json_encode($feature) }})" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition flex items-center gap-1 cursor-pointer">
                            <span>✏️</span>
                            <span>تعديل</span>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

    </main>

    <!-- نافذة تعديل إعدادات الميزة (Modern Edit Modal) -->
    <div id="editFeatureModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-[#111827] rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 animate-fade-in-down space-y-5">
            
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="flex items-center gap-3">
                    <span id="modalIcon" class="text-3xl">📱</span>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white" id="modalTitle">تعديل إعدادات الواجهة</h3>
                        <p class="text-xs text-slate-500" id="modalKeyText"></p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-700 dark:hover:text-white flex items-center justify-center font-bold text-xl cursor-pointer">&times;</button>
            </div>

            <form id="editFeatureForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">اسم الواجهة بالعربية <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="modalNameInput" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">الأيقونة (Emoji)</label>
                        <input type="text" name="icon" id="modalIconInput" placeholder="📊 أو 🧾" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-center">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">نوع الإجراء عند التعطيل <span class="text-rose-500">*</span></label>
                        <select name="action_type" id="modalActionSelect" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                            <option value="lock">🔒 قفل مع رسالة للمستخدم</option>
                            <option value="hide">👁️ إخفاء كلي من القائمة</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">رسالة التعطيل التي تظهر في التطبيق للمستخدم</label>
                    <textarea name="disabled_message" id="modalMessageTextarea" rows="3" placeholder="اكتب الرسالة التوضيحية التي ستظهر للمستخدم عند محاولة فتح هذه الواجهة..." class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white"></textarea>
                    <p class="text-[11px] text-slate-500 mt-1">تظهر هذه الرسالة عند اختيار خيار "قفل مع رسالة".</p>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">وصف الواجهة (داخلي)</label>
                    <input type="text" name="description" id="modalDescInput" placeholder="وصف محتوى الواجهة..." class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2.5">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer">
                        إلغاء
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-extrabold bg-amber-600 hover:bg-amber-700 text-white transition shadow-md shadow-amber-900/20 cursor-pointer">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- نافذة إضافة واجهة جديدة -->
    <div id="newFeatureModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-[#111827] rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 animate-fade-in-down space-y-5">
            
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="flex items-center gap-2.5">
                    <span class="text-2xl">➕</span>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">إضافة واجهة جديدة للتحكم بها</h3>
                </div>
                <button onclick="document.getElementById('newFeatureModal').classList.add('hidden')" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-700 dark:hover:text-white flex items-center justify-center font-bold text-xl cursor-pointer">&times;</button>
            </div>

            <form action="{{ route('admin.features.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">المعرّف التقني بالإنجليزية (Feature Key) <span class="text-rose-500">*</span></label>
                    <input type="text" name="key" required placeholder="مثال: inventory_screen أو pos_quick" pattern="^[a-zA-Z0-9_]+$" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white font-mono">
                    <p class="text-[11px] text-slate-500 mt-1">يجب أن يتطابق مع المعرّف المستخدم في كود Flutter.</p>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">اسم الواجهة بالعربية <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="مثال: شاشة المستودع والجرد" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">الأيقونة (Emoji)</label>
                        <input type="text" name="icon" placeholder="📦" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-center">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">نوع الإجراء <span class="text-rose-500">*</span></label>
                        <select name="action_type" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                            <option value="lock">🔒 قفل مع رسالة تنبيه</option>
                            <option value="hide">👁️ إخفاء كلي من القائمة</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1.5">رسالة التعطيل الافتراضية</label>
                    <textarea name="disabled_message" rows="2" placeholder="هذه الميزة معطلة مؤقتاً لأعمال الصيانة والتطوير..." class="w-full rounded-xl border border-slate-300 dark:border-slate-700 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white dark:bg-slate-900 text-slate-900 dark:text-white"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('newFeatureModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer">
                        إلغاء
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-extrabold bg-emerald-600 hover:bg-emerald-700 text-white transition shadow-md shadow-emerald-900/20 cursor-pointer">
                        إضافة وتفعيل
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- تذييل الصفحة -->
    <footer class="bg-white dark:bg-[#111827] border-t border-slate-200/80 dark:border-slate-800 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-500 dark:text-slate-400">
            لوحة تحكم تطبيق نـور &copy; {{ date('Y') }} • نظام التحكم الديناميكي بالميزات والواجهات
        </div>
    </footer>

    <!-- سكريبت الفلترة والتعديل والوضع الليلي -->
    <script>
        // فتح المودال
        function openEditModal(feature) {
            document.getElementById('editFeatureForm').action = '/admin/features/' + feature.id;
            document.getElementById('modalTitle').textContent = 'تعديل: ' + feature.name;
            document.getElementById('modalKeyText').textContent = 'المعرّف التقني: ' + feature.key;
            document.getElementById('modalIcon').textContent = feature.icon || '📱';
            document.getElementById('modalNameInput').value = feature.name;
            document.getElementById('modalIconInput').value = feature.icon || '';
            document.getElementById('modalActionSelect').value = feature.action_type || 'lock';
            document.getElementById('modalMessageTextarea').value = feature.disabled_message || '';
            document.getElementById('modalDescInput').value = feature.description || '';
            document.getElementById('editFeatureModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editFeatureModal').classList.add('hidden');
        }

        // فلترة بالبحث
        function filterFeatures() {
            const query = document.getElementById('featureSearchInput').value.toLowerCase().trim();
            const items = document.querySelectorAll('.feature-item');
            
            items.forEach(item => {
                const key = item.getAttribute('data-key') || '';
                const name = item.getAttribute('data-name') || '';
                if (key.includes(query) || name.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // فلترة بالحالة (الكل / مفعل / معطل)
        let currentFilter = 'all';
        function setFilter(filter) {
            currentFilter = filter;
            const items = document.querySelectorAll('.feature-item');
            
            ['all', 'enabled', 'disabled'].forEach(f => {
                const btn = document.getElementById('filter-' + f);
                if (f === filter) {
                    btn.classList.add('bg-white', 'dark:bg-slate-800', 'text-slate-900', 'dark:text-white', 'shadow-sm');
                    btn.classList.remove('text-slate-600', 'dark:text-slate-400');
                } else {
                    btn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-slate-900', 'dark:text-white', 'shadow-sm');
                    btn.classList.add('text-slate-600', 'dark:text-slate-400');
                }
            });

            items.forEach(item => {
                const status = item.getAttribute('data-status');
                if (filter === 'all' || status === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

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
