<?php

namespace App\Exports;

use App\Models\CentreMaster;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CenterExport implements FromCollection,WithHeadings,WithMapping
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
	
	
	
	public function map($centers): array
    {

    	//print_r($centres);die;
		$services_available= '';
		
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
			
		$servicesArr = explode(',',$centers->services_available); 
		
		foreach($services as $key=>$value){
			if(!in_array($key,$servicesArr))
				continue;
											
				$services_available .= $value.",";												
		}
		
		$services_avail='';
		
		if(isset($centers->services_avail) && !empty($centers->services_avail)){

			
												
			if(!empty($centers->services_avail)){	
				$serviceOrginAval = explode(",",$centers->services_avail);
				foreach($serviceOrginAval as $val){
					$services_avail .= $val;
				}
				$services_avail = rtrim($services_avail,',');
			}
		}
		
				
        return [
           
            $centers->name,
            $centers->address,
            $centers->state_name,
            $centers->district_name,
            $centers->pin_code,
            rtrim($services_available,","),
            $services_avail,
            $centers->centre_contact_no,
            $centers->incharge
        ];
    }
	
	public function headings(): array
    {
        return [
			'Name',	
			'Address', 	
			'State',	
			'District',	
			'PinCode',	
			'Services',
			'Facility_Type',
			'Centre Contact No',	
			'Name of the ICTC Incharge'	
			         
        ];
    }
}
