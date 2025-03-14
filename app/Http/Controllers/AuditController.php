<?php

namespace App\Http\Controllers;

use App\Models\AuditableModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        $audits = AuditableModel::with('user')->latest()->paginate(10);

        return Inertia::render('Audit/Index', [
            'audits' => $audits
        ]);
    }

    public function show()
    {
        return Inertia::render('Audit/Show');
    }
}
