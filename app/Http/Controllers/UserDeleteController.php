<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class UserDeleteController extends Controller
{
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $user->delete();
        }

        return redirect('/');
    }
}
