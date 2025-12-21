<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        return view('shop.checkout', [
            'user' => $user ? [
                'name' => $user->name,
                'email' => $user->email,
                'full_address' => $user->full_address,
                'avatar' => $user->profile_photo_path ? Storage::url($user->profile_photo_path) : null,
            ] : null,
        ]);
    }
}
