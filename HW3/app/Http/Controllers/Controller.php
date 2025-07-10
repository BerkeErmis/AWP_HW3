<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function __construct()
    {
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
    }
}
