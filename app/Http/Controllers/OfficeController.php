<?php

namespace App\Http\Controllers;

use App\Http\Requests\Office\StoreOfficeRequest;
use App\Http\Requests\Office\UpdateOfficeRequest;
use App\Http\Services\OfficeService;
use App\Models\Office;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeController extends Controller
{
    protected $officeService;

    public function __construct(OfficeService $officeService)
    {
        $this->officeService = $officeService;
    }
    public function index()
    {
        $offices = Office::latest()->paginate(10);

        return Inertia::render('Office/Index', [
            'offices' => $offices
        ]);
    }

    public function destroy(Office $office)
    {
        $office->delete();
        return back();
    }

    public function create()
    {
        return Inertia::render('Office/Create');
    }

    public function edit(Office $office)
    {
        return Inertia::render('Office/Edit', [
            'office' => $office
        ]);
    }

    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $this->officeService->updateOffice($request->validated(), $office);
        return to_route('offices.index');
    }

    public function store(StoreOfficeRequest $request)
    {
        $this->officeService->createOffice($request->validated());
        return to_route('offices.index');
    }
}
