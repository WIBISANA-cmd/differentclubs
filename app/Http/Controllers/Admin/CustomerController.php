<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::query()
            ->where('role', 'client')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }
}
