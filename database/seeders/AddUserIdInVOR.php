<?php

namespace Database\Seeders;

use App\Models\Outreach\{Counselling, PLHIV, Profile, ReferralService, RiskAssessment};
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class AddUserIdInVOR extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $userData = User::select('id')->selectRaw('LOWER(email) as email')->get();
            $userData = $userData->pluck('email')->combine($userData->pluck('id'));

            $outreach = [
                new Profile,
                new RiskAssessment,
                new ReferralService,
                new PLHIV,
                new Counselling
            ];

            foreach ($outreach as $module) {
                $data = $module->select('id')->selectRaw("substring_index(lower(unique_serial_number),'/',1)  as unique_serial_number")->get();
                $data = LazyCollection::make($data)->pluck('unique_serial_number')->unique()->values()->collect();

                foreach ($data as $vn) {
                    if ($userData->has($vn))
                        $module->whereRaw("substring_index(lower(unique_serial_number),'/',1) = ?", $vn)->update(['user_id' => $userData->get($vn)]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
        }
    }
}
