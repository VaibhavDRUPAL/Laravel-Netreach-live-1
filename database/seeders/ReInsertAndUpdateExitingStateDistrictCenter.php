<?php

namespace Database\Seeders;

use App\Imports\{StateDistrict, TestingCenters};
use App\Models\{CentreMaster, DistrictMaster, StateMaster};
use App\Models\Outreach\{Counselling, PLHIV, Profile, ReferralService};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{DB, Schema, Storage};
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class ReInsertAndUpdateExitingStateDistrictCenter extends Seeder
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

            $currentDateTime = currentDateTime(FOR_FILE_NAME_FORMAT);

            // Get Existing Data
            $existingStateData = StateMaster::all();
            $existingDistrictData = DistrictMaster::all();
            $existingCenterData = CentreMaster::all();
            $existingProfileData = Profile::all();
            $existingReferralServiceData = ReferralService::all();
            $existingPLHIVData = PLHIV::all();
            $existingCounsellingData = Counselling::all();

            // JSON Backup
            mediaOperations(BACKUP_PATH . 'states' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingStateData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'districts' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingDistrictData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'centers' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingCenterData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'profile' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingProfileData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'referral_service' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingReferralServiceData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'plhiv' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingPLHIVData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'counselling' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingCounsellingData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            // Backup Zip
            $backupZip = new ZipArchive;
            $backupZip->open(storage_path('app' . BACKUP_PATH . 'zip/backup' . UNDERSCORE . $currentDateTime . '.zip'), ZipArchive::CREATE);
            $backupFiles = Storage::disk('local')->files('/backup/');
            foreach ($backupFiles as $file) {
                if (!empty(pathinfo($file)['filename']))
                    $backupZip->addFile(storage_path('app/' . $file), basename($file));
            }
            $backupZip->close();

            // Sheet Data
            $sheetData = Excel::toCollection(new StateDistrict, '/states/states_districts.xlsx', STD_LOCAL);

            /**
             * State
             */
            // Sheet States
            $sheetStates = $sheetData['state'];

            // Existing Data
            $stateWeights = collect()->make();
            $stateRegions = collect()->make();

            $existingStateWeights = $existingStateData->pluck('state_name')->combine($existingStateData->pluck('weight'));
            $existingStateRegions = $existingStateData->pluck('state_name')->combine($existingStateData->pluck('region'));
            $existingStateID = $existingStateData->pluck('id')->combine($existingStateData->pluck('state_name'));

            $existingStateWeights = $existingStateWeights->each(function ($value, $key) use ($stateWeights) {
                return $stateWeights->put(ucwords(Str::lower(Str::squish($key))), $value);
            });
            $existingStateRegions = $existingStateRegions->each(function ($value, $key) use ($stateRegions) {
                return $stateRegions->put(ucwords(Str::lower(Str::squish($key))), intval($value));
            });

            $sheetStates = $sheetStates->each(function ($value) use ($stateWeights, $stateRegions) {
                $value->put('region', $stateRegions->get($value->get('state_name')));
                $value->put('weight', $stateWeights->get($value->get('state_name'), 0));

                return $value;
            });

            // Add New State Data
            DB::delete('delete from state_master');
            StateMaster::insert($sheetStates->toArray());

            /**
             * District
             */

            // Sheet Districts
            $sheetDistrict = $sheetData['district']->lazy();

            // Latest States
            $latestStateData = StateMaster::select(STAR)->selectRaw('lower(state_name) as state_name')->orderBy('state_name')->get();
            $latestStateID = $latestStateData->pluck('state_name')->combine($latestStateData->pluck('id'));
            $latestStateCode = $latestStateData->pluck('state_name')->combine($latestStateData->pluck('state_code'));

            $sheetDistrict = $sheetDistrict->each(function ($value) use ($latestStateID, $latestStateCode) {
                $value->put('state_id', $latestStateID->get(Str::lower($value['state_name'])));
                $value->put('state_code', $latestStateCode->get(Str::lower($value['state_name'])));
                $value->forget('state_name');

                return $value;
            });

            DB::delete('delete from district_master');
            DistrictMaster::insert($sheetDistrict->toArray());

            // Latest District Data
            $latestDistrictData = DistrictMaster::select(STAR)->selectRaw('lower(district_name) as district_name')->orderBy('district_name')->get();
            $latestDistrictID = $latestDistrictData->pluck('district_name')->combine($latestDistrictData->pluck('id'));

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
                        $sheetCenters->lazy()->each(function ($value) use ($currentDateTime, $centersData, $latestStateID, $latestDistrictID, $latestStateCode) {
                            if ($latestStateID->has($value['state']) && $latestDistrictID->has($value['district'])) {
                                $centersData->push([
                                    'name' => ucwords($value['center_name']),
                                    'address' => $value['address'],
                                    'district_id' => $latestDistrictID->get($value['district']),
                                    'state_code' => $latestStateCode->get($value['state']),
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

            DB::delete('delete from centre_master');
            $centersData->lazy()->chunk($chunkSize)->each(function ($value) {
                CentreMaster::insert($value->all());
            });

            $latestCenterData = CentreMaster::select(STAR)->selectRaw('lower(name) as name')->orderBy('name')->get();
            $latestCenterID = $latestCenterData->pluck('name')->combine($latestCenterData->pluck('id'));

            /**
             * Outreach - Profile
             */
            $profileData = Profile::whereNot('district_id', 0)->orWhereNot('state_id', 0)->get();

            if ($profileData->isNotEmpty()) {
                // Profile State
                $profileStateData = $profileData->unique('state_id');
                $profileStateData = $profileStateData->pluck('state_id');
                $profileStateData->each(function ($value) use ($existingStateID, $latestStateID) {
                    if (!empty($value) && $latestStateID->has(Str::lower($existingStateID->get($value))))
                        Profile::where('state_id', $value)->update(['state_id' => $latestStateID->get(Str::lower($existingStateID->get($value)))]);
                });

                // Existing Data
                $existingDistrictID = $existingDistrictData->pluck('id')->combine($existingDistrictData->pluck('district_name'));
                $existingCenterID = $existingCenterData->pluck('id')->combine($existingCenterData->pluck('name'));

                // Profile District
                $profileDistrictData = $profileData->unique('district_id');
                $profileDistrictData = $profileDistrictData->pluck('district_id');
                $profileDistrictData->each(function ($value) use ($existingDistrictID, $latestDistrictID) {
                    if (!empty($value) && $latestDistrictID->has(Str::lower($existingDistrictID->get($value))))
                        Profile::where('state_id', $value)->update(['state_id' => $latestDistrictID->get(Str::lower($existingDistrictID->get($value)))]);
                });
            }

            /**
             * Outreach- PLHIV
             */
            $plhivData = PLHIV::whereNotNull('art_centre_district')->orWhereNotNull('art_centre_state')->orWhereNotNull('art_centre_id')->get();

            if ($plhivData->isNotEmpty()) {
                // PLHIV State
                $plhivStateData = $plhivData->unique('art_centre_state');
                $plhivStateData = $plhivStateData->pluck('art_centre_state');
                $plhivStateData->each(function ($value) use ($existingStateID, $latestStateID) {
                    if (!empty($value) && $latestStateID->has(Str::lower($existingStateID->get($value))))
                        PLHIV::where('art_centre_state', $value)->update(['art_centre_state' => $latestStateID->get(Str::lower($existingStateID->get($value)))]);
                });

                // PLHIV District
                $plhivDistrictData = $plhivData->unique('art_centre_district');
                $plhivDistrictData = $plhivDistrictData->pluck('art_centre_district');
                $plhivDistrictData->each(function ($value) use ($existingDistrictID, $latestDistrictID) {
                    if (!empty($value) && $latestDistrictID->has(Str::lower($existingDistrictID->get($value))))
                        PLHIV::where('art_centre_district', $value)->update(['art_centre_district' => $latestDistrictID->get(Str::lower($existingDistrictID->get($value)))]);
                });

                // PLHIV Center
                $plhivCenterData = $plhivData->unique('art_centre_id');
                $plhivCenterData = $plhivCenterData->pluck('art_centre_id');
                $plhivCenterData->each(function ($value) use ($existingCenterID, $latestCenterID) {
                    $latestCenterID = $latestCenterID->lazy();
                    if (!empty($value) && $latestCenterID->has(Str::lower($existingCenterID->get($value))))
                        PLHIV::where('art_centre_id', $value)->update(['art_centre_id' => $latestCenterID->get(Str::lower($existingCenterID->get($value)))]);
                });
            }

            /**
             * Outreach - Referral Services
             */
            $referralServicesData = ReferralService::whereNotNull('referral_center_id')->orWhereNotNull('referred_centre_state')->orWhereNotNull('referred_centre_district')->get();

            if ($referralServicesData->isNotEmpty()) {
                // Referral Service State
                $referralServicesStateData = $referralServicesData->unique('referred_centre_state');
                $referralServicesStateData = $referralServicesStateData->pluck('referred_centre_state');
                $referralServicesStateData->each(function ($value) use ($existingStateID, $latestStateID) {
                    if (!empty($value) && $latestStateID->has(Str::lower($existingStateID->get(intval($value)))))
                        ReferralService::where('referred_centre_state', $value)->update(['referred_centre_state' => $latestStateID->get(Str::lower($existingStateID->get(intval($value))))]);
                });

                // Referral Service District
                $referralServicesDistrictData = $referralServicesData->unique('referred_centre_district');
                $referralServicesDistrictData = $referralServicesDistrictData->pluck('referred_centre_district');
                $referralServicesDistrictData->each(function ($value) use ($existingDistrictID, $latestDistrictID) {
                    if (!empty($value) && $latestDistrictID->has(Str::lower($existingDistrictID->get(intval($value)))))
                        ReferralService::where('referred_centre_district', $value)->update(['referred_centre_district' => $latestDistrictID->get(Str::lower($existingDistrictID->get(intval($value))))]);
                });

                // Referral Service Center
                $referralServicesCenterData = $referralServicesData->unique('referral_center_id');
                $referralServicesCenterData = $referralServicesCenterData->pluck('referral_center_id');
                $referralServicesCenterData->each(function ($value) use ($existingCenterID, $latestCenterID) {
                    if (!empty($value) && $latestCenterID->has(Str::lower($existingCenterID->get(intval($value)))))
                        ReferralService::where('referral_center_id', $value)->update(['referral_center_id' => $latestCenterID->get(Str::lower($existingCenterID->get(intval($value))))]);
                });
            }

            /**
             * Outreach - Counselling Service
             */
            $counsellingData = Counselling::whereNotNull('state_id')->orWhereNotNull('district_id')->get();

            if ($counsellingData->isNotEmpty()) {
                // Counselling State
                $counsellingStateData = $referralServicesData->unique('state_id');
                $counsellingStateData = $counsellingStateData->pluck('state_id');
                $counsellingStateData->each(function ($value) use ($existingStateID, $latestStateID) {
                    if (!empty($value) && $latestStateID->has(Str::lower($existingStateID->get(intval($value)))))
                        Counselling::where('state_id', $value)->update(['state_id' => $latestStateID->get(Str::lower($existingStateID->get(intval($value))))]);
                });

                // Counselling District
                $counsellingDistrictData = $referralServicesData->unique('district_id');
                $counsellingDistrictData = $counsellingDistrictData->pluck('district_id');
                $counsellingDistrictData->each(function ($value) use ($existingDistrictID, $latestDistrictID) {
                    if (!empty($value) && $latestDistrictID->has(Str::lower($existingDistrictID->get(intval($value)))))
                        ReferralService::where('referred_centre_district', $value)->update(['referred_centre_district' => $latestDistrictID->get(Str::lower($existingDistrictID->get(intval($value))))]);
                });
            }

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