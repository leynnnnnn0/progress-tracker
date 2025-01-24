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
            [
                'name' => 'Office of the Vice President for Research and Extension',
                'office_code' => 'OVPRE'
            ],
            [
                'name' => 'Office of Research Services',
                'office_code' => 'ORS'
            ],
            [
                'name' => 'Office of Extension Services',
                'office_code' => 'OES'
            ],
            [
                'name' => 'Intellectual Property Rights Office',
                'office_code' => 'IPRO'
            ],
            [
                'name' => 'Research and Extension Publication Office',
                'office_code' => 'REPO'
            ],
            [
                'name' => 'Highland Training Institute',
                'office_code' => 'HORTI'
            ],
            [
                'name' => 'Northern Philippines Root Crops Research and Training Center',
                'office_code' => 'NPRCRTC'
            ],
            [
                'name' => 'Institute of Highland Farming Systems and Agroforestry',
                'office_code' => 'IHFSA'
            ],
            [
                'name' => 'Institute of Social Research and Development',
                'office_code' => 'ISRD'
            ],
            [
                'name' => 'Higher Education Regional Research Center',
                'office_code' => 'HERRC'
            ],
            [
                'name' => 'Cordillera Organic Agriculture Research and Development Center',
                'office_code' => 'COARDC'
            ],
            [
                'name' => 'Climate Smart Agriculture Center',
                'office_code' => 'CSAC'
            ],
            [
                'name' => 'Cordillera Regional Apiculture Center',
                'office_code' => 'CRAC'
            ],
            [
                'name' => 'Agri-based Technology Business Incubator/Innovation Center',
                'office_code' => 'ATBI/IC'
            ],
            [
                'name' => 'Food Science Research and Innovation Center',
                'office_code' => 'FSRIC'
            ],
            [
                'name' => 'Center for Geoinformatics',
                'office_code' => 'GIS'
            ],
            [
                'name' => 'Cordillera Center for Animal Research and Development',
                'office_code' => 'CCCARD'
            ],
            [
                'name' => 'Cordillera Soil, Plants, and Water Service Laboratory',
                'office_code' => 'CSPWSL'
            ]
        ];

        foreach ($offices as $office) {
            Office::create($office);
        }
    }
}
