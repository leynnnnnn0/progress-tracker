<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::paginate(10);

        return Inertia::render('Office/Index', [
            'offices' => $offices
        ]);
    }
}
