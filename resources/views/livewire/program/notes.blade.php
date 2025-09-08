<?php

use App\Models\ProgramItem;
use App\Models\ProgramNote;
use Carbon\Carbon;
use function Livewire\Volt\{state, computed, mount};

state([
    'items' => [],
    'selectedItemId' => null,
    'noteContent' => '',
    'showNoteModal' => false,
    'editingNoteId' => null,
]);

mount(function () {
    $this->items = ProgramItem::with([
        'notes' => function ($query) {
            $query->where('user_id', auth()->id())->orderBy('created_at', 'desc');
        },
    ])
        ->orderBy('category')
        ->orderBy('order')
        ->get();
});

$openNoteModal = function (int $itemId, ?int $noteId = null) {
    $this->selectedItemId = $itemId;
    $this->showNoteModal = true;

    if ($noteId) {
        $this->editingNoteId = $noteId;
        $note = ProgramNote::find($noteId);
        if ($note) {
            $this->noteContent = $note->content;
        }
    } else {
        $this->editingNoteId = null;
        $this->noteContent = '';
    }
};

$saveNote = function () {
    if ($this->editingNoteId) {
        $note = ProgramNote::find($this->editingNoteId);
        if ($note) {
            $note->update([
                'content' => $this->noteContent,
            ]);
        }
    } else {
        ProgramNote::create([
            'user_id' => auth()->id(),
            'program_item_id' => $this->selectedItemId,
            'content' => $this->noteContent,
        ]);
    }

    $this->showNoteModal = false;
    $this->selectedItemId = null;
    $this->noteContent = '';
    $this->editingNoteId = null;

    $this->items = ProgramItem::with([
        'notes' => function ($query) {
            $query->where('user_id', auth()->id())->orderBy('created_at', 'desc');
        },
    ])
        ->orderBy('category')
        ->orderBy('order')
        ->get();
};

$deleteNote = function (int $noteId) {
    $note = ProgramNote::find($noteId);
    if ($note) {
        $note->delete();
    }

    $this->items = ProgramItem::with([
        'notes' => function ($query) {
            $query->where('user_id', auth()->id())->orderBy('created_at', 'desc');
        },
    ])
        ->orderBy('category')
        ->orderBy('order')
        ->get();
};

$closeModal = function () {
    $this->showNoteModal = false;
    $this->selectedItemId = null;
    $this->noteContent = '';
    $this->editingNoteId = null;
};

$getCategories = computed(function () {
    return collect($this->items)->pluck('category')->unique();
});

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('メモ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($this->getCategories as $category)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">{{ $category }}</h3>
                            <div class="space-y-4">
                                @foreach ($items->where('category', $category) as $item)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-sm font-medium">{{ $item->name }}</h4>
                                            <button wire:click="openNoteModal({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                メモを追加
                                            </button>
                                        </div>

                                        @if ($item->description)
                                            <p class="text-sm text-gray-600 mb-4">{{ $item->description }}</p>
                                        @endif

                                        @if ($item->notes->count() > 0)
                                            <div class="space-y-3">
                                                @foreach ($item->notes as $note)
                                                    <div class="bg-white rounded-lg p-3 shadow-sm">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-grow">
                                                                <p class="text-sm text-gray-900 whitespace-pre-wrap">
                                                                    {{ $note->content }}</p>
                                                                <p class="mt-1 text-xs text-gray-500">
                                                                    {{ $note->created_at->format('Y年n月j日 H:i') }}
                                                                </p>
                                                            </div>
                                                            <div class="flex items-center space-x-2 ml-4">
                                                                <button
                                                                    wire:click="openNoteModal({{ $item->id }}, {{ $note->id }})"
                                                                    class="text-gray-400 hover:text-gray-500">
                                                                    <svg class="h-4 w-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                                <button wire:click="deleteNote({{ $note->id }})"
                                                                    class="text-gray-400 hover:text-gray-500">
                                                                    <svg class="h-4 w-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- メモ入力モーダル -->
    @if ($showNoteModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">
                                {{ $editingNoteId ? 'メモを編集' : 'メモを追加' }}
                            </h3>
                            <div class="mt-2">
                                <textarea wire:model="noteContent"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    rows="4" placeholder="メモを入力してください"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button wire:click="saveNote" type="button"
                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">
                            保存
                        </button>
                        <button wire:click="closeModal" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">
                            キャンセル
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
