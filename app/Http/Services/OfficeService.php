<?php

namespace App\Http\Services;

use App\Models\Office;

class OfficeService
{

    public function createOffice(array $data)
    {
        return Office::create($data);
    }

    public function updateOffice(array $data, Office $office)
    {
        return $office->update($data);
    }
}
