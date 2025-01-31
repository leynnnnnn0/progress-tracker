<?php

namespace App\Http\Services;

use App\Models\Office;

class OfficeService
{

    public function createOffice(array $data)
    {
        return Office::create($data);
    }

    public function updateOffice(array $data, $id)
    {
        $office = Office::findOrFail($id);
        return $office->update($data);
    }
}
