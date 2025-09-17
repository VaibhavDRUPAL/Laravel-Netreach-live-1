<?php

namespace Database\Seeders;

use App\Imports\TestingCenters;
use App\Models\{BookAppinmentMaster, CentreMaster, DistrictMaster, StateMaster};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Schema, Storage};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TestingCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            if (!Storage::disk('local')->exists('centers/testing_center.xlsx')) return;

            DB::reconnect();
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Excel Data
            $data = Excel::toCollection(new TestingCenters, 'centers/testing_center.xlsx', 'local');
            $data = $data[0];
            if ($data->isEmpty()) return;

            $excelStateData = $data->pluck('state')->unique();
            $excelDistrictData = $data->pluck('district')->unique();
            $excelDistrictState = $data->pluck('district')->combine($data->pluck('state'));

            $currentDateTime = currentDateTime();

            // Existing States
            $maxStateCode = StateMaster::max('state_code');
            $existingStateData = StateMaster::select(DB::raw('lower(state_name) as state_name'), 'id')->get();
            $existingStateData = $existingStateData->pluck('id')->combine($existingStateData->pluck('state_name'));
            $latestStateData = collect()->make();
            foreach ($excelStateData as $state) {
                if (!empty($state) && !$existingStateData->contains($state)) {
                    $latestStateData->push([
                        'state_code' => ++$maxStateCode,
                        'state_name' => ucwords(Str::squish($state)),
                        'region' => 1
                    ]);
                }
            }
            if ($latestStateData->isNotEmpty()) StateMaster::insert($latestStateData->all());

            // Existing District
            $existingStateData = StateMaster::select(DB::raw('lower(state_name) as state_name'), 'state_code')->get();
            $existingStateData = $existingStateData->pluck('state_code')->combine($existingStateData->pluck('state_name'));

            $existingDistrictData = DistrictMaster::select(DB::raw('lower(district_name) as district_name'), 'id')->get();
            $existingDistrictData = $existingDistrictData->pluck('id')->combine($existingDistrictData->pluck('district_name'));
            $latestDistrictData = collect()->make();
            $stateCodeCount = collect()->make();

            foreach ($excelDistrictData as $district) {
                $state = $excelDistrictState->get($district);
                $stateCode = $existingStateData->search($state);
                $count = $stateCodeCount->has($state) ? $stateCodeCount->get($state) : 0;

                if (!empty($district) && !$existingDistrictData->contains($district)) {
                    $latestDistrictData->push([
                        'state_code' => $stateCode,
                        'district_code' => $stateCode . 0 . ++$count,
                        'district_name' => ucwords(Str::squish($district))
                    ]);
                    $stateCodeCount->put($state, $count);
                }
            }

            if ($latestDistrictData->isNotEmpty()) DistrictMaster::insert($latestDistrictData->all());

            // Existing Booked Centers
            $existingBookedCenters = BookAppinmentMaster::select('center_ids')->distinct('center_ids')->get()?->pluck('center_ids')->toArray();
            $existingCenters = CentreMaster::select('id')->get();

            // Existing Centers
            $existingCenterIDs = $existingCenters->pluck('id');

            $unwantedData = $existingCenterIDs->diff($existingBookedCenters)->values();

            if ($unwantedData->isNotEmpty()) CentreMaster::destroy($unwantedData);

            $existingCenters = CentreMaster::select(DB::raw('lower(name) as name'))->get();
            $existingCenterNames = $existingCenters->pluck('name');

            // State Data
            $stateData = StateMaster::select(DB::raw('lower(state_name) as state_name'), 'state_code')->get();
            $stateData = $stateData->pluck('state_name')->combine($stateData->pluck('state_code'));

            // District Data
            $districtData = DistrictMaster::select(DB::raw('lower(district_name) as district_name'), 'district_code')->get();
            $districtData = $districtData->pluck('district_name')->combine($districtData->pluck('district_code'));

            // Excel Chunk Data
            $chunkData = $data->chunk(250);

            // Assign New Data
            foreach ($chunkData as $chunk) {
                $centerData = collect()->make();
                foreach ($chunk as $value) {
                    if (!$existingCenterNames->contains($value['center_name'])) {
                        $centerData->push([
                            'name' => ucwords($value['center_name']),
                            'district_id' => $districtData->get($value['district']),
                            'state_code' => $stateData->get($value['state']),
                            'address' => $value['address'],
                            'name_counsellor' => $value['name_counsellor'],
                            'contact_no' => $value['contact_no'],
                            'services_avail' => $value['type_of_facility'],
                            'services_available' => $value['type_of_services'],
                            'created_at' => $currentDateTime
                        ]);
                    }
                }

                if ($centerData->isNotEmpty()) CentreMaster::insert($centerData->all());
            }

            rename(storage_path('app/centers/testing_center.xlsx'), storage_path('app/centers/testing_center_clean.xlsx'));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
        }
    }
}