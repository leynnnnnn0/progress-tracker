<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            'OES',
            'ORS',
            'IPRO',
            'REPO',
            'HPRCRTC',
            'HORTI',
            'IHFSA',
            'ISRD',
            'ATBI/IC',
            'FSRIC',
            'HERRC',
            'CSAC',
            'CRAC',
            'CCARD',
            'COARDC',
            'GIS',
            'BUGUIAS',
            'BOKOD',
            'LAB',
            'CORCAARD',
            'OVPRE'
        ];
        foreach ($offices as $office) {
            Office::create([
                'name' => $office
            ]);
        };
    }
}
