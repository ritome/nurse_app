<?php

use App\Models\ProgramCheck;
use App\Models\ProgramItem;
use Carbon\Carbon;
use function Livewire\Volt\{state, computed, mount};

state(['items' => []]);

mount(function () {
    $this->items = ProgramItem::with([
        'checks' => function ($query) {
            $query->where('user_id', auth()->id());
        },
    ])
        ->orderBy('category')
        ->orderBy('order')
        ->get();
});

$toggleCheck = function (int $itemId) {
    $item = ProgramItem::find($itemId);
    if (!$item) {
        return;
    }

    $check = $item->checks->where('user_id', auth()->id())->first();

    if ($check) {
        $check->delete();
    } else {
        ProgramCheck::create([
            'user_id' => auth()->id(),
            'program_item_id' => $itemId,
            'checked_at' => Carbon::now(),
        ]);
    }

    $this->items = ProgramItem::with([
        'checks' => function ($query) {
            $query->where('user_id', auth()->id());
        },
    ])
        ->orderBy('category')
        ->orderBy('order')
        ->get();
};

$getCategories = computed(function () {
    return collect($this->items)->pluck('category')->unique();
});

$getCompletedCount = computed(function () {
    return collect($this->items)
        ->filter(function ($item) {
            return $item->checks->where('user_id', auth()->id())->count() > 0;
        })
        ->count();
});

$getTotalCount = computed(function () {
    return count($this->items);
});

$getCompletionRate = computed(function () {
    if ($this->getTotalCount === 0) {
        return 0;
    }
    return ($this->getCompletedCount / $this->getTotalCount) * 100;
});

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新入看護職員育成プログラム') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ヘッダー -->
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-lg font-semibold">進捗状況</h3>
                        <a href="{{ route('program.notes') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            メモを管理
                        </a>
                    </div>

                    <!-- 進捗状況 -->
                    <div class="mb-8">
                        <div class="bg-gray-100 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-gray-600">達成項目：</span>
                                    <span class="font-medium">{{ $this->getCompletedCount }}</span>
                                    <span class="text-gray-600">/</span>
                                    <span class="font-medium">{{ $this->getTotalCount }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">達成率：</span>
                                    <span class="font-medium">
                                        {{ number_format($this->getCompletionRate, 1) }}%
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full"
                                    style="width: {{ $this->getCompletionRate }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- チェックリスト -->
                    @foreach ($this->getCategories as $category)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">{{ $category }}</h3>
                            <div class="space-y-4">
                                @foreach ($items->where('category', $category) as $item)
                                    <div
                                        class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex-shrink-0">
                                            <button wire:click="toggleCheck({{ $item->id }})"
                                                class="w-6 h-6 rounded border-2 {{ $item->checks->where('user_id', auth()->id())->count() > 0 ? 'bg-indigo-600 border-indigo-600' : 'border-gray-300' }} flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                @if ($item->checks->where('user_id', auth()->id())->count() > 0)
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="text-sm font-medium">{{ $item->name }}</h4>
                                            @if ($item->description)
                                                <p class="mt-1 text-sm text-gray-600">{{ $item->description }}</p>
                                            @endif
                                            @if ($item->checks->where('user_id', auth()->id())->count() > 0)
                                                <p class="mt-2 text-xs text-gray-500">
                                                    達成日:
                                                    {{ $item->checks->where('user_id', auth()->id())->first()->checked_at->format('Y年n月j日') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
