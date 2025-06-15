<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirectUser()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect('/admin');
        } elseif ($role === 'salesperson') {
            return redirect('/sales');
        }

        return redirect('/dashboard'); // fallback
    }
}
