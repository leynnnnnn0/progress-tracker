<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TargetController extends Controller
{
    public function index()
    {
        return Inertia::render('Target/Index');
    }

    public function create()
    {
        return Inertia::render('Target/Create');
    }
}
