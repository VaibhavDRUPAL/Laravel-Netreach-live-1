<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Imports\OutreachImport;
use App\Models\Outreach\{Counselling, PLHIV, Profile, ReferralService, RiskAssessment, STIService};
use App\Models\{CentreMaster, ClientResponse, ClientType, DistrictMaster, Platform, ReasonForNotAccessingService, ServiceType, StateMaster, STIService as ParentSTIService, TargetPopulation, TIService, User};
use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OutreachSeeder extends Seeder
{
    protected $filename;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // State Details
            $stateDetails = StateMaster::all();
            $stateDetails = $stateDetails->pluck('id')->combine($stateDetails->pluck('state_code'));

            // District Details
            $districtDetails = DistrictMaster::all();
            $districtDetails = $districtDetails->pluck('id')->combine($districtDetails->pluck('district_code'));

            // Center Details
            $centerDetails = CentreMaster::select('id')->selectRaw('LOWER(TRIM(name)) as ' . CentreMaster::center_name)->get();
            $centerDetails = $centerDetails->pluck('id')->combine($centerDetails->pluck(CentreMaster::center_name))->lazy();

            // User Details
            $userDetails = User::select(STAR)->selectRaw('LOWER(TRIM(email))')->get();
            $userDetails = $userDetails->pluck('id')->combine($userDetails->pluck('email'));

            // Platform Details
            $platformDetails = Platform::select('id')->selectRaw('LOWER(TRIM(name))')->get();
            $platformDetails = $platformDetails->pluck('id');

            // Target Population
            $targetPopulationDetails = TargetPopulation::select(TargetPopulation::target_id)->selectRaw('LOWER(TRIM(' . TargetPopulation::target_type . '))')->get();
            $targetPopulationDetails = $targetPopulationDetails->pluck(TargetPopulation::target_id);

            // Client Response
            $clientResponseDetails = ClientResponse::select(ClientResponse::response_id)->selectRaw('LOWER(TRIM(' . ClientResponse::response . '))')->get();
            $clientResponseDetails = $clientResponseDetails->pluck(ClientResponse::response_id);

            // Client Type
            $clientTypeDetails = ClientType::select(ClientType::client_type_id)->selectRaw('LOWER(TRIM(' . ClientType::client_type . '))')->get();
            $clientTypeDetails = $clientTypeDetails->pluck(ClientType::client_type_id);

            // TI Service
            $tiServiceDetails = TIService::select(TIService::ti_service_id)->selectRaw('LOWER(TRIM(' . TIService::ti_service . '))')->get();
            $tiServiceDetails = $tiServiceDetails->pluck(TIService::ti_service_id);

            // STI Service
            $stiServiceDetails = ParentSTIService::select(ParentSTIService::sti_service_id)->selectRaw('LOWER(TRIM(' . ParentSTIService::sti_service . '))')->get();
            $stiServiceDetails = $stiServiceDetails->pluck(ParentSTIService::sti_service_id);

            // Service Type
            $serviceTypeDetails = ServiceType::select(ServiceType::service_type_id)->selectRaw('LOWER(TRIM(' . ServiceType::service_type . '))')->get();
            $serviceTypeDetails = $serviceTypeDetails->pluck(ServiceType::service_type_id);

            // Reason For Not Accessing Service
            $reasonForNotAccessingServiceDetails = ReasonForNotAccessingService::select(ReasonForNotAccessingService::reason_id)->selectRaw('LOWER(TRIM(' . ReasonForNotAccessingService::reason . '))')->get();
            $reasonForNotAccessingServiceDetails = $reasonForNotAccessingServiceDetails->pluck(ReasonForNotAccessingService::reason_id);

            $chunkSize = 500;
            $currentDateTime = currentDateTime();

            $outreachFiles = Storage::disk('local')->files('/outreach/');

            foreach ($outreachFiles as $file) {
                if (!empty(pathinfo($file)['filename'])) {
                    DB::beginTransaction();

                    $this->filename = pathinfo($file)['basename'];

                    $parentSheetData = Excel::toCollection(new OutreachImport, 'outreach/' . $this->filename, 'local')->lazy();

                    /**
                     * Outreach: Profile
                     */
                    if ($parentSheetData->has('outreach')) {

                        $sheetData = $parentSheetData->get('outreach')->lazy()->chunk($chunkSize);

                        foreach ($sheetData as $chunkProfile) {

                            $profileData = collect()->make();

                            foreach ($chunkProfile as $profile) {
                                // ---------------------------------------new import code by mansi--------------------------------------
                                
                                // ---------------------------------------new import code by mansi ends--------------------------------------
                                $profileData->push([
                                    Profile::district_id => $districtDetails->search($profile->get(DistrictMaster::district)) ? $districtDetails->search($profile->get(DistrictMaster::district)) : null,
                                    Profile::state_id => $stateDetails->search($profile->get(StateMaster::state)) ? $stateDetails->search($profile->get(StateMaster::state)) : null,
                                    Profile::platform_id => $platformDetails->contains($profile->get(Platform::platform_name)) ? $profile->get(Platform::platform_name) : null,
                                    Profile::gender_id => $profile->get(Profile::gender),
                                    Profile::target_id => $targetPopulationDetails->contains($profile->get(TargetPopulation::target_population)) ? $profile->get(TargetPopulation::target_population) : null,
                                    Profile::response_id => $clientResponseDetails->contains($profile->get(ClientResponse::client_response)) ? $profile->get(ClientResponse::client_response) : null,
                                    Profile::client_type_id => $clientTypeDetails->contains($profile->get(ClientType::client_type)) ? $profile->get(ClientType::client_type) : null,
                                    Profile::user_id => $userDetails->contains(strtok($profile->get(Profile::unique_serial_number), '/')) ? $userDetails->search(strtok($profile->get(Profile::unique_serial_number), '/')) : null,
                                    Profile::mention_platform_id => $platformDetails->contains($profile->get(Platform::other_virtual_platform)) ? $profile->get(Platform::other_virtual_platform) : null,
                                    Profile::region_id => $profile->get(Profile::region_id),
                                    Profile::unique_serial_number => Str::upper($profile->get(Profile::unique_serial_number)),
                                    Profile::age => $profile->get(Profile::age),
                                    Profile::uid => $profile->get(Profile::uid),
                                    Profile::registration_date => $profile->get(Profile::registration_date),
                                    Profile::location => $profile->get(Profile::location),
                                    Profile::other_platform => $profile->get(Profile::other_platform),
                                    Profile::profile_name => $profile->get(Profile::profile_name),
                                    Profile::age => $profile->get(Profile::age),
                                    Profile::other_gender => $profile->get(Profile::other_gender),
                                    Profile::virtual_platform => $profile->get(Platform::use_other_virtual_platform),
                                    Profile::reached_out => $profile->get(Profile::reached_out) == 1 ? true : false,
                                    Profile::phone_number => $profile->get(Profile::phone_number),
                                    Profile::follow_up_date => $profile->get(Profile::follow_up_date),
                                    Profile::shared_website_link => $profile->get(Profile::shared_website_link),
                                    Profile::remarks => $profile->get(Profile::remarks),
                                    Profile::created_at => $currentDateTime
                                ]);
                            }

                            if ($profileData->isNotEmpty())
                                Profile::insert($profileData->all());
                        }
                    }

                    /**
                     * Outreach: Risk Assessment
                     */
                    if ($parentSheetData->has('risk_assessment')) {

                        $profileDetails = Profile::select(Profile::profile_id)->selectRaw('LOWER(' . Profile::unique_serial_number . ') as ' . Profile::unique_serial_number . '')->get();
                        $profileDetails = $profileDetails->pluck(Profile::profile_id)->combine($profileDetails->pluck(Profile::unique_serial_number))->lazy()->chunk($chunkSize);

                        $sheetData = $parentSheetData->get('risk_assessment')->lazy()->chunk($chunkSize);
                        $remainingRiskAssessmentData = collect()->make();

                        foreach ($sheetData as $chunkRiskAssessment) {

                            $riskAssessmentData = collect()->make();

                            foreach ($chunkRiskAssessment as $riskAssessment) {
                                $profileID = null;
                                foreach ($profileDetails as $chunk) {
                                    if ($chunk->contains($riskAssessment->get(Profile::unique_serial_number))) {
                                        $profileID = $chunk->search($riskAssessment->get(Profile::unique_serial_number));
                                        break;
                                    }
                                }
                                if (!empty($profileID)) {
                                    $riskAssessmentData->push([
                                        RiskAssessment::profile_id => $profileID,
                                        RiskAssessment::client_type_id => $clientTypeDetails->contains($riskAssessment->get(ClientType::client_type)) ? $riskAssessment->get(ClientType::client_type) : null,
                                        RiskAssessment::provided_client_with_information => $riskAssessment->get(RiskAssessment::provided_client_with_information),
                                        RiskAssessment::types_of_information => $riskAssessment->get(RiskAssessment::types_of_information),
                                        RiskAssessment::user_id => $userDetails->contains(strtok($riskAssessment->get(Profile::unique_serial_number), '/')) ? $userDetails->search(strtok($riskAssessment->get(Profile::unique_serial_number), '/')) : null,
                                        RiskAssessment::date_of_risk_assessment => $riskAssessment->get(RiskAssessment::date_of_risk_assessment),
                                        RiskAssessment::had_sex_without_a_condom => $riskAssessment->get(RiskAssessment::had_sex_without_a_condom),
                                        RiskAssessment::shared_needle_for_injecting_drugs => $riskAssessment->get(RiskAssessment::shared_needle_for_injecting_drugs),
                                        RiskAssessment::sexually_transmitted_infection => $riskAssessment->get(RiskAssessment::sexually_transmitted_infection),
                                        RiskAssessment::sex_with_more_than_one_partners => $riskAssessment->get(RiskAssessment::sex_with_more_than_one_partners),
                                        RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex => $riskAssessment->get(RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex),
                                        RiskAssessment::had_sex_in_exchange_of_goods_or_money => $riskAssessment->get(RiskAssessment::had_sex_in_exchange_of_goods_or_money),
                                        RiskAssessment::other_reason_for_hiv_test => $riskAssessment->get(RiskAssessment::other_reason_for_hiv_test),
                                        RiskAssessment::risk_category => $riskAssessment->get(RiskAssessment::risk_category),
                                        RiskAssessment::created_at => $currentDateTime
                                    ]);
                                } else
                                    $remainingRiskAssessmentData->push($riskAssessment);
                            }

                            if ($riskAssessmentData->isNotEmpty())
                                RiskAssessment::insert($riskAssessmentData->all());
                        }
                    }

                    /**
                     * Outreach: Referral
                     */
                    if ($parentSheetData->has('referral')) {

                        $sheetData = $parentSheetData->get('referral')->lazy()->chunk($chunkSize);

                        $remainingReferralData = collect()->make();

                        foreach ($sheetData as $chunkReferral) {

                            $referralData = collect()->make();

                            foreach ($chunkReferral as $referral) {
                                $profileID = null;
                                foreach ($profileDetails as $chunk) {
                                    if ($chunk->contains($referral->get(Profile::unique_serial_number))) {
                                        $profileID = $chunk->search($referral->get(Profile::unique_serial_number));
                                        break;
                                    }
                                }
                                if (!empty($profileID)) {
                                    $referralData->push([
                                        ReferralService::profile_id => $profileID,
                                        ReferralService::client_type_id => $clientTypeDetails->contains($referral->get(ClientType::client_type)) ? $referral->get(ClientType::client_type) : null,
                                        ReferralService::ti_service_id => $tiServiceDetails->contains($referral->get(TIService::ti_service)) ? $referral->get(TIService::ti_service) : null,
                                        ReferralService::service_type_id => $serviceTypeDetails->contains($referral->get(ServiceType::service_type)) ? $referral->get(ServiceType::service_type) : null,
                                        ReferralService::user_id => $userDetails->contains(strtok($referral->get(Profile::unique_serial_number), '/')) ? $userDetails->search(strtok($referral->get(Profile::unique_serial_number), '/')) : null,
                                        ReferralService::netreach_uid_number => $referral->get(ReferralService::netreach_uid_number),
                                        ReferralService::other_service_type => $referral->get(ReferralService::other_service_type),
                                        ReferralService::other_services => $referral->get(ReferralService::other_services),
                                        ReferralService::other_ti_services => $referral->get(ReferralService::other_ti_services),
                                        ReferralService::other_referred_service => $referral->get(ReferralService::other_referred_service),
                                        ReferralService::counselling_service => $referral->get(ReferralService::counselling_service),
                                        ReferralService::prevention_programme => $referral->get(ReferralService::prevention_programme),
                                        ReferralService::type_of_facility_where_referred => $referral->get(ReferralService::type_of_facility_where_referred),
                                        ReferralService::referral_date => $referral->get(ReferralService::referral_date),
                                        ReferralService::name_of_different_center => $referral->get(ReferralService::name_of_different_center),
                                        ReferralService::referred_district_id => $districtDetails->search($referral->get(ReferralService::referred_district)) ? $districtDetails->search($referral->get(ReferralService::referred_district)) : null,
                                        ReferralService::referred_state_id => $stateDetails->search($referral->get(ReferralService::referred_state)) ? $stateDetails->search($referral->get(ReferralService::referred_state)) : null,
                                        ReferralService::referral_center_id => $centerDetails->search($referral->get(CentreMaster::center_name)) ? $centerDetails->search($referral->get(CentreMaster::center_name)) : null,
                                        ReferralService::type_of_facility_where_tested => $referral->get(ReferralService::type_of_facility_where_tested),
                                        ReferralService::test_centre_district_id => $districtDetails->search($referral->get(ReferralService::test_centre_district)) ? $districtDetails->search($referral->get(ReferralService::test_centre_district)) : null,
                                        ReferralService::test_centre_state_id => $stateDetails->search($referral->get(ReferralService::test_centre_state)) ? $stateDetails->search($referral->get(ReferralService::test_centre_state)) : null,
                                        ReferralService::date_of_accessing_service => $referral->get(ReferralService::date_of_accessing_service),
                                        ReferralService::applicable_for_hiv_test => $referral->get(ReferralService::applicable_for_hiv_test),
                                        ReferralService::sti_service_id => $stiServiceDetails->search($referral->get(ParentSTIService::sti_service)) ? $stiServiceDetails->search($referral->get(ParentSTIService::sti_service)) : null,
                                        ReferralService::other_sti_service => $referral->get(ReferralService::other_sti_service),
                                        ReferralService::pid_or_other_unique_id_of_the_service_center => $referral->get(ReferralService::pid_or_other_unique_id_of_the_service_center),
                                        ReferralService::outcome_of_the_service_sought => $referral->get(ReferralService::outcome_of_the_service_sought),
                                        ReferralService::reason_id => $reasonForNotAccessingServiceDetails->search($referral->get(ReasonForNotAccessingService::reason_for_not_accessing_service)) ? $reasonForNotAccessingServiceDetails->search($referral->get(ReasonForNotAccessingService::reason_for_not_accessing_service)) : null,
                                        ReferralService::other_not_access => $referral->get(ReferralService::other_not_access),
                                        ReferralService::follow_up_date => $referral->get(ReferralService::follow_up_date),
                                        ReferralService::remarks => $referral->get(ReferralService::remarks),
                                        ReferralService::created_at => $currentDateTime
                                    ]);
                                } else
                                    $remainingReferralData->push($referral);
                            }

                            if ($referralData->isNotEmpty())
                                ReferralService::insert($referralData->all());
                        }
                    }

                    /**
                     * Outreach: PLHIV
                     */
                    if ($parentSheetData->has('plhiv')) {

                        $referralServiceDetails = ReferralService::select(ReferralService::referral_service_id, ReferralService::netreach_uid_number)->get();
                        $referralServiceDetails = $referralServiceDetails->pluck(ReferralService::referral_service_id)->combine($referralServiceDetails->pluck(ReferralService::netreach_uid_number))->lazy()->chunk($chunkSize);

                        $sheetData = $parentSheetData->get('plhiv')->lazy()->chunk($chunkSize);

                        $remainingPlhivData = collect()->make();

                        foreach ($sheetData as $chunkPlhiv) {

                            $plhivData = collect()->make();

                            foreach ($chunkPlhiv as $plhiv) {
                                $profileID = null;
                                $referralServiceID = null;
                                foreach ($profileDetails as $chunk) {
                                    if ($chunk->contains($plhiv->get(Profile::unique_serial_number))) {
                                        $profileID = $chunk->search($plhiv->get(Profile::unique_serial_number));
                                        break;
                                    }
                                }
                                foreach ($referralServiceDetails as $referralChunk) {
                                    if ($referralChunk->contains($plhiv->get(ReferralService::netreach_uid_number))) {
                                        $referralServiceID = $referralChunk->search($plhiv->get(ReferralService::netreach_uid_number));
                                        break;
                                    }
                                }
                                if (!empty($profileID)) {
                                    $plhivData->push([
                                        PLHIV::profile_id => $profileID,
                                        PLHIV::referral_service_id => $referralServiceID,
                                        PLHIV::client_type_id => $clientTypeDetails->contains($plhiv->get(ClientType::client_type)) ? $plhiv->get(ClientType::client_type) : null,
                                        PLHIV::user_id => $userDetails->contains(strtok($plhiv->get(Profile::unique_serial_number), '/')) ? $userDetails->search(strtok($plhiv->get(Profile::unique_serial_number), '/')) : null,
                                        PLHIV::registration_date => $plhiv->get(PLHIV::registration_date),
                                        PLHIV::pid_or_other_unique_id_of_the_service_center => $plhiv->get(PLHIV::pid_or_other_unique_id_of_the_service_center),
                                        PLHIV::date_of_confirmatory => $plhiv->get(PLHIV::date_of_confirmatory),
                                        PLHIV::date_of_art_reg => $plhiv->get(PLHIV::date_of_art_reg),
                                        PLHIV::pre_art_reg_number => $plhiv->get(PLHIV::pre_art_reg_number),
                                        PLHIV::date_of_on_art => $plhiv->get(PLHIV::date_of_on_art),
                                        PLHIV::on_art_reg_number => $plhiv->get(PLHIV::on_art_reg_number),
                                        PLHIV::type_of_facility_where_treatment_sought => $plhiv->get(PLHIV::type_of_facility_where_treatment_sought),
                                        PLHIV::art_state_id => $stateDetails->search($plhiv->get(PLHIV::art_state)) ? $stateDetails->search($plhiv->get(PLHIV::art_state)) : null,
                                        PLHIV::art_district_id => $districtDetails->search($plhiv->get(PLHIV::art_district)) ? $districtDetails->search($plhiv->get(PLHIV::art_district)) : null,
                                        PLHIV::art_center_id => $centerDetails->search($plhiv->get(PLHIV::art_center)) ? $centerDetails->search($plhiv->get(PLHIV::art_center)) : null,
                                        PLHIV::remarks => $plhiv->get(PLHIV::remarks),
                                        PLHIV::created_at => $currentDateTime
                                    ]);
                                } else
                                    $remainingPlhivData->push($plhivData);
                            }

                            if ($plhivData->isNotEmpty())
                                PLHIV::insert($plhivData->all());
                        }
                    }

                    /**
                     * Outreach: STI line list
                     */
                    if ($parentSheetData->has('sti_line_list')) {

                        $sheetData = $parentSheetData->get('sti_line_list')->lazy()->chunk($chunkSize);

                        $remainingStiLineListData = collect()->make();

                        foreach ($sheetData as $chunkStiLineList) {

                            $stiLineListData = collect()->make();

                            foreach ($chunkStiLineList as $stiLineList) {
                                $profileID = null;
                                $referralServiceID = null;
                                foreach ($profileDetails as $chunk) {
                                    if ($chunk->contains($stiLineList->get(Profile::unique_serial_number))) {
                                        $profileID = $chunk->search($stiLineList->get(Profile::unique_serial_number));
                                        break;
                                    }
                                }
                                foreach ($referralServiceDetails as $referralChunk) {
                                    if ($referralChunk->contains($stiLineList->get(ReferralService::netreach_uid_number))) {
                                        $referralServiceID = $referralChunk->search($stiLineList->get(ReferralService::netreach_uid_number));
                                        break;
                                    }
                                }
                                if (!empty($profileID)) {
                                    $stiLineListData->push([
                                        STIService::profile_id => $profileID,
                                        STIService::referral_service_id => $referralServiceID,
                                        STIService::client_type_id => $clientTypeDetails->contains($stiLineList->get(ClientType::client_type)) ? $stiLineList->get(ClientType::client_type) : null,
                                        STIService::state_id => $stateDetails->search($stiLineList->get(StateMaster::state)) ? $stateDetails->search($stiLineList->get(StateMaster::state)) : null,
                                        STIService::district_id => $districtDetails->search($stiLineList->get(DistrictMaster::district)) ? $districtDetails->search($stiLineList->get(DistrictMaster::district)) : null,
                                        STIService::center_id => $centerDetails->search($stiLineList->get(CentreMaster::center_name)) ? $centerDetails->search($stiLineList->get(CentreMaster::center_name)) : null,
                                        STIService::user_id => $userDetails->contains(strtok($stiLineList->get(Profile::unique_serial_number), '/')) ? $userDetails->search(strtok($stiLineList->get(Profile::unique_serial_number), '/')) : null,
                                        STIService::date_of_sti => $stiLineList->get(STIService::date_of_sti),
                                        STIService::pid_or_other_unique_id_of_the_service_center => $stiLineList->get(STIService::pid_or_other_unique_id_of_the_service_center),
                                        STIService::sti_service_id => $stiServiceDetails->search($stiLineList->get(ParentSTIService::sti_service)) ? $stiServiceDetails->search($stiLineList->get(ParentSTIService::sti_service)) : null,
                                        STIService::type_facility_where_treated => $stiLineList->get(STIService::type_facility_where_treated),
                                        STIService::applicable_for_syphillis => $stiLineList->get(STIService::applicable_for_syphillis),
                                        STIService::remarks => $stiLineList->get(STIService::remarks),
                                        STIService::is_treated => $stiLineList->get(STIService::treated),
                                        STIService::created_at => $currentDateTime
                                    ]);
                                } else
                                    $remainingStiLineListData->push($stiLineList);
                            }

                            if ($stiLineListData->isNotEmpty())
                                STIService::insert($stiLineListData->all());
                        }
                    }

                    /**
                     * Outreach: Counselling
                     */
                    if ($parentSheetData->has('counselling')) {

                        $sheetData = $parentSheetData->get('counselling')->lazy()->chunk($chunkSize);

                        $remainingCounsellingData = collect()->make();

                        foreach ($sheetData as $chunkCounselling) {

                            $counsellingData = collect()->make();

                            foreach ($chunkCounselling as $counselling) {
                                $profileID = null;
                                $referralServiceID = null;
                                foreach ($profileDetails as $chunk) {
                                    if ($chunk->contains($counselling->get(Profile::unique_serial_number))) {
                                        $profileID = $chunk->search($counselling->get(Profile::unique_serial_number));
                                        break;
                                    }
                                }
                                foreach ($referralServiceDetails as $referralChunk) {
                                    if ($referralChunk->contains($counselling->get(ReferralService::netreach_uid_number))) {
                                        $referralServiceID = $referralChunk->search($counselling->get(ReferralService::netreach_uid_number));
                                        break;
                                    }
                                }
                                if (!empty($profileID)) {
                                    $counsellingData->push([
                                        Counselling::profile_id => $profileID,
                                        Counselling::client_type_id => $clientTypeDetails->contains($counselling->get(ClientType::client_type)) ? $counselling->get(ClientType::client_type) : null,
                                        Counselling::user_id => $userDetails->contains(strtok($counselling->get(Profile::unique_serial_number), '/')) ? $userDetails->search(strtok($counselling->get(Profile::unique_serial_number), '/')) : null,
                                        Counselling::referral_service_id => $referralServiceID,
                                        Counselling::district_id => $districtDetails->search($counselling->get(DistrictMaster::district)) ? $districtDetails->search($counselling->get(DistrictMaster::district)) : null,
                                        Counselling::state_id => $stateDetails->search($counselling->get(StateMaster::state)) ? $stateDetails->search($counselling->get(StateMaster::state)) : null,
                                        Counselling::target_id => $targetPopulationDetails->contains($counselling->get(TargetPopulation::target_population)) ? $counselling->get(TargetPopulation::target_population) : null,
                                        Counselling::referred_from => $counselling->get(Counselling::referred_from),
                                        Counselling::referral_source => $counselling->get(Counselling::referral_source),
                                        Counselling::date_of_counselling => $counselling->get(Counselling::date_of_counselling),
                                        Counselling::phone_number => $counselling->get(Counselling::phone_number),
                                        Counselling::location => $counselling->get(Counselling::location),
                                        Counselling::other_target_population => $counselling->get(Counselling::other_target_population),
                                        Counselling::type_of_counselling_offered => $counselling->get(Counselling::type_of_counselling_offered),
                                        Counselling::type_of_counselling_offered_other => $counselling->get(Counselling::type_of_counselling_offered_other),
                                        Counselling::counselling_medium => $counselling->get(Counselling::counselling_medium),
                                        Counselling::other_counselling_medium => $counselling->get(Counselling::other_counselling_medium),
                                        Counselling::duration_of_counselling => $counselling->get(Counselling::duration_of_counselling),
                                        Counselling::key_concerns_discussed => $counselling->get(Counselling::key_concerns_discussed),
                                        Counselling::follow_up_date => $counselling->get(Counselling::follow_up_date),
                                        Counselling::remarks => $counselling->get(Counselling::remarks),
                                        Counselling::created_at => $currentDateTime
                                    ]);
                                } else
                                    $remainingCounsellingData->push($counselling);

                                if ($counsellingData->isNotEmpty())
                                    Counselling::insert($counsellingData->all());
                            }
                        }
                    }
                    Storage::disk('local')->move('outreach/' . $this->filename, 'outreach/clean/' . $this->filename);
                    DB::commit();
                    sleep(5);
                }
            }

            $data = collect([
                'risk_assessment' => isset($remainingRiskAssessmentData) ? $remainingRiskAssessmentData : null,
                'referral' => isset($remainingReferralData) ? $remainingReferralData : null,
                'plhiv' => isset($remainingPlhivData) ? $remainingPlhivData : null,
                'sti_line_list' => isset($remainingStiLineListData) ? $remainingStiLineListData : null,
                'counselling' => isset($remainingCounsellingData) ? $remainingCounsellingData : null
            ])->toJson();

            mediaOperations(BACKUP_PATH . 'remaining_data_' . getFileName() . EXT_JSON, $data, FL_CREATE, MDT_STORAGE, STD_LOCAL);


        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
            logger($this->filename);
        }
    }
}