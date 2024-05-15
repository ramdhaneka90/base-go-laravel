<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Position;
use Illuminate\Database\Seeder;

class DivisionAndPositionSeeder extends Seeder
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
                'name' => 'Security',
                'positions' => [
                    'Deputy', 'Supervisi', 'Leader', 'Anggota',
                ],
            ],
            [
                'name' => 'Housekeeping',
                'positions' => [
                    'Leader', 'Anggota',
                ],
            ],
        ];

        foreach ($data as $item) {
            $division = new Division();
            $division->name = $item['name'];
            $division->save();

            foreach ($item['positions'] as $itemPosition) {
                $position = new Position();
                $position->division_id = $division->id;
                $position->name = $itemPosition;
                $position->save();
            }
        }
    }
}
