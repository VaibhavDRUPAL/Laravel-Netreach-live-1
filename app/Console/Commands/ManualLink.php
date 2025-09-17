<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ManualLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manual:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vn Manual Link Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		\Log::info("Cron is working fine!");
		
		$results = User::whereNull('manual_link')->get();
		if($results->count() > 0){
			
			foreach($results as $key=>$value){
				
				$sqlUser = User::find($value->id);
				$sqlUser->manual_link = md5($value->id);
				$sqlUser->save();				
			}
			
		}		
		$this->info('Demo:Cron Cummand Run successfully!');
        return 0;
    }
}
