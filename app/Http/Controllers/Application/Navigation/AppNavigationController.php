<?php

namespace App\Http\Controllers\Application\Navigation;

use App\Http\Controllers\Controller;

class AppNavigationController extends Controller
{
    public function __invoke()
    {
        return view('components.layouts.main');
    }
}
