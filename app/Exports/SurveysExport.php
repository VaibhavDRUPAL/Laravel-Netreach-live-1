<?php

namespace App\Exports;

use App\Models\Surveys;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveysExport implements FromCollection,WithHeadings,WithMapping
{	
	
	
	public function __construct($arrays)
    {
		
		/*dd($arrays);
        $output = [];

        foreach ($arrays as $array) {
            // get headers for current dataset
            $output[] = array_keys($array[0]);
            // store values for each row
            foreach ($array as $row) {
                $output[] = array_values($row);
            }
            // add an empty row before the next dataset
            $output[] = [''];
        }*/

        $this->collection = $arrays;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		
		
		
		//dd($this->collection);
		/*return Surveys::select('U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
			->whereIn('BAM.state_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36])
			->orderBy('surveys.id', 'DESC');*/
			
        return $this->collection;
    }
	
	
	
	public function map($surveys): array
    {
		$service_required= '';
		$genderArr = array("1"=>"Male","2"=>"Female","3"=>"Transgender","4"=>"I prefer not to say","5"=>"I prefer not to say","6"=>"Other");
		$services = array(
									"1"=>"HIV Test",
									"2"=>"STI Services",
									"3"=>"PrEP",
									"4"=>"PEP",
									"5"=>"Counselling on Mental Health",
									"6"=>"Referral to TI services",
									"7"=>"ART Linkages"
									);
		$serviceAval = array("0"=>"",1=>"ICTC",2=>"FICTC",3=>"ART",4=>"TI",5=>"Private lab");
			
		$servicesArr = json_decode($surveys->services_required); 
		$service_required= '';
		if(isset($servicesArr)){
			foreach($services as $key=>$value){
				if(!in_array($key,$servicesArr))
					continue;
												
					$service_required .= $value.",";												
			}
		}
		
		$services_avail='';
		if(isset($surveys->services_avail) && !empty($surveys->services_avail)){
												
			if(!empty($surveys->services_avail)){	
				$serviceOrginAval = explode(",",$surveys->services_avail);
				foreach($serviceOrginAval as $val){
					$services_avail .= $serviceAval[$val].",";
				}
				$services_avail = rtrim($services_avail,',');
			}
		}

		$ip_addressArr = json_decode($surveys->survey_details,true);
		$ip_address       = isset($ip_addressArr["IPv4"]) ? $ip_addressArr["IPv4"] : '-';	
		

		if(!empty($surveys->platforms_name)){
					$platforms_name = $surveys->platforms_name;
				}else{
					if($surveys->manual_flag > 0){
						$platforms_name = "Manual";
					}else{
						$platforms_name = "Walk-in";
					}
				}

		
		if($surveys->outcome==1)
			$outcome = 'Negative';
		else if($surveys->outcome==2)
			$outcome ='Positive';
		else if($surveys->outcome==3)
			$outcome ='Non-reactive';	
		else
			$outcome='';
		
        return [
            ($surveys->client_type==1) ? 'New Client' : 'Follow Up Client',
            date("d/m/Y",strtotime($surveys->book_date)),
            $ip_address,
            $surveys->state_name,
            $surveys->district_name,
            $platforms_name,
            $surveys->your_age,
            $genderArr[$surveys->identify_yourself],
            $surveys->target_population,
            $surveys->client_phone_number,
			$surveys->risk_level,
            $surveys->uid,
            rtrim($service_required,","),
            ($surveys->hiv_test==1)?'Yes' :'No',
            $services_avail,
            $surveys->client_name,
            $surveys->appoint_date,
            $surveys->center_name,
            $surveys->acess_date,
            $surveys->pid,
            $outcome
        ];
    }
	
	public function headings(): array
    {
        return [
			'Client_Type',	
			'Assessment_Date', 	
			'IP ADDRESS',	
			'State',	
			'District',	
			'Platform',	
			'Age',	
			'Gender',	
			'Target_Pop',	
			'Mobile',	
			'Risk',	
			'UID',	
			'Services',
			'TI',	
			'Facility_Type',
			'Name',	
			'Referral_Date',	
			'Centre',	
			'Acess_Date',	
			'PID', 	
			'Outcome'            
        ];
    }
}