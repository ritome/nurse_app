<?php

namespace App\Http\Controllers;

use App\Models\ProgramItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $items = ProgramItem::with(['checks' => function ($query) {
            $query->where('user_id', auth()->id());
        }])
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        $categories = $items->pluck('category')->unique();

        return view('program.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }
}
