<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新入看護職員育成プログラム') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ユーザー情報 -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">基本情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="text-gray-600">職員番号：</span>
                                <span class="font-medium">{{ Auth::user()->employee_id }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">氏名：</span>
                                <span class="font-medium">{{ Auth::user()->full_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">役職：</span>
                                <span class="font-medium">
                                    @switch(Auth::user()->role)
                                        @case('new_nurse')
                                            新入看護職員
                                        @break

                                        @case('partner_nurse')
                                            パートナー看護師
                                        @break

                                        @case('educator')
                                            教育係
                                        @break

                                        @case('chief')
                                            主任
                                        @break

                                        @case('manager_safety')
                                            課長（医療安全）
                                        @break

                                        @case('manager_infection')
                                            課長（感染制御）
                                        @break

                                        @case('manager_hrd')
                                            課長（人材育成）
                                        @break

                                        @case('director')
                                            部長
                                        @break

                                        @default
                                            {{ Auth::user()->role }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- メニュー -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- 新入看護職員育成プログラム -->
                        <div
                            class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2">新入看護職員育成プログラム</h3>
                                <p class="text-gray-600 mb-4">必須経験事項のチェックリストと進捗管理</p>
                                <a href="{{ route('program.index') }}"
                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                    チェックリストを開く
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- 振り返りシート -->
                        <div
                            class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2">振り返りシート</h3>
                                <p class="text-gray-600 mb-4">節目ごとの面談・承認記録</p>
                                <a href="#"
                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                    振り返りシートを開く
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- 日々の振り返り記録 -->
                        <div
                            class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2">日々の振り返り記録</h3>
                                <p class="text-gray-600 mb-4">毎日の実施内容と気づきの記録</p>
                                <a href="#"
                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                    記録を開く
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
