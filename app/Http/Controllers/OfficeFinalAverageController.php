<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeFinalAverageController extends Controller
{
    public function index()
    {
        $offices = Office::latest()
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn($office) => [
                'id' => $office->id,
                'name' => $office->name,
                'office_code' => $office->office_code,
            ]);
        return Inertia::render('OfficeFinalAverage/Index', [
            'offices' => $offices
        ]);
    }
}
