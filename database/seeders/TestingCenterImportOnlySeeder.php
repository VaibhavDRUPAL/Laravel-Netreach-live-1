<?php

namespace Database\Seeders;

use App\Imports\TestingCenters;
use App\Models\{CentreMaster, DistrictMaster, StateMaster};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Schema, Storage};
use Maatwebsite\Excel\Facades\Excel;

class TestingCenterImportOnlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            Schema::disableForeignKeyConstraints();

            $chunkSize = 250;

            // Latest States
            $stateData = StateMaster::select(STAR)->selectRaw('lower(state_name) as state_name')->orderBy('state_name')->get();
            $stateID = $stateData->pluck('state_name')->combine($stateData->pluck('id'));
            $stateCode = $stateData->pluck('state_name')->combine($stateData->pluck('state_code'));

            // Latest District Data
            $districtData = DistrictMaster::select(STAR)->selectRaw('lower(district_name) as district_name')->orderBy('district_name')->get();
            $districtID = $districtData->pluck('district_name')->combine($districtData->pluck('id'));

            /**
             * Centers
             */
            $currentDateTime = currentDateTime();
            $centersData = collect()->make();

            $centerFiles = Storage::disk('local')->files('/centers/');

            foreach ($centerFiles as $value) {
                if (!empty(pathinfo($value)['filename'])) {
                    $sheetCenters = Excel::toCollection(new TestingCenters, 'centers/' . pathinfo($value)['basename'], 'local');
                    $sheetCenters = $sheetCenters->first();
                    if ($sheetCenters->isNotEmpty()) {
                        $sheetCenters->lazy()->each(function ($value) use ($currentDateTime, $centersData, $stateID, $districtID, $stateCode) {
                            if ($stateID->has($value['state']) && $districtID->has($value['district'])) {
                                $centersData->push([
                                    'name' => ucwords($value['center_name']),
                                    'address' => $value['address'],
                                    'district_id' => $districtID->get($value['district']),
                                    'state_code' => $stateCode->get($value['state']),
                                    'name_counsellor' => $value['name_counsellor'],
                                    'contact_no' => $value['contact_no'],
                                    'services_avail' => $value['type_of_facility'],
                                    'services_available' => $value['type_of_services'],
                                    'created_at' => $currentDateTime
                                ]);
                            }
                        });
                    }
                }
            }

            $centersData->lazy()->chunk($chunkSize)->each(function ($value) {
                CentreMaster::insert($value->all());
            });

            /**
             * Move Center files to clean
             */
            $centerFiles = Storage::disk('local')->files('/centers/');
            foreach ($centerFiles as $value) {
                if (!empty(pathinfo($value)['filename']))
                    Storage::disk('local')->move('centers/' . pathinfo($value)['basename'], 'centers/clean/' . pathinfo($value)['basename']);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
        }
    }
}