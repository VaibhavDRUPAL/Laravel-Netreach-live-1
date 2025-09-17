<?php

namespace Database\Seeders;

use App\Models\StateMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $data = [
                9 => [
                    Str::lower('Mizoram')
                ],
                7 => [
                    Str::lower('Nagaland'),
                    Str::lower('Manipur')
                ],
                6 => [
                    Str::lower('Andhra Pradesh')
                ],
                5 => [
                    Str::lower('Delhi'),
                    Str::lower('Goa'),
                    Str::lower('Karnataka'),
                    Str::lower('Meghalaya'),
                    Str::lower('Maharashtra'),
                    Str::lower('Puducherry'),
                    Str::lower('Telangana')
                ],
                4 => [
                    Str::lower('Haryana'),
                    Str::lower('Punjab'),
                    Str::lower('Tamil Nadu')
                ],
                3 => [
                    Str::lower('Andaman & Nicobar Islands'),
                    Str::lower('Bihar'),
                    Str::lower('Chandigarh'),
                    Str::lower('Chhattisgarh'),
                    Str::lower('Dadra & Nagar  Haveli  and  Daman & Diu'),
                    Str::lower('Gujarat'),
                    Str::lower('Himachal Pradesh'),
                    Str::lower('Odisha'),
                    Str::lower('Tripura')
                ],
                2 => [
                    Str::lower('Arunachal Pradesh'),
                    Str::lower('Assam'),
                    Str::lower('Jammu & Kashmir'),
                    Str::lower('Jharkhand'),
                    Str::lower('Kerala'),
                    Str::lower('Ladakh'),
                    Str::lower('Madhya Pradesh'),
                    Str::lower('Rajasthan'),
                    Str::lower('Sikkim'),
                    Str::lower('Uttar Pradesh')
                ]
            ];

            foreach ($data as $key => $value)
                StateMaster::whereIn(DB::raw('LOWER(`state_name`)'), $value)->update(['weight' => $key]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
        }
    }
}
