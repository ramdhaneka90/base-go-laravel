<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Area;
use Illuminate\Database\Seeder;

class RegionAndAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Bandung',
                'areas' => [
                    'Area A',
                    'Area B',
                    'Area C',
                ],
            ],
        ];

        foreach ($data as $item) {
            $region = new Region();
            $region->name = $item['name'];
            $region->save();

            foreach ($item['areas'] as $itemArea) {
                $area = new Area();
                $area->region_id = $region->id;
                $area->name = $itemArea;
                $area->save();
            }
        }
    }
}
