<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body{padding: 0;margin:0;font-family: Arial, Helvetica, sans-serif;}
        table{width: 100%;}
        table,tr,td,th{border-collapse: collapse;font-size: 16px;padding:15px;}
        th{background: #f2f2f2;text-align: left;}
    </style>
</head>
<body>
    <table>
        <tr>
            <td style="padding: 0;">
                <table style="padding:35px 0;">
                    <tr>
                        <td><img src="{{asset('assets/img/web/logo.png')}}"></td>
                        <td style="text-align: right;"><img src="{{asset('assets/img/web/humsafar-logo.png')}}" style="width: 125px"></td>
                    </tr>
                </table>
                <table style="background: #146f98;color:#fff">
                    <tr>
                        <td></td>
                        <td style="background: #fff;width: 165px;color: #146f98;font-size: 33px;text-transform: uppercase;text-align: center;font-weight: 600;">E-Referral Slip</td>
                        <td style="width: 50px;"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="line-height: 24px;"><strong>Client Name</strong><br>{{$book_results->client_name}}<br>{{$book_results->client_email}}</td>
                        <td style="text-align: right;"><strong>Date :</strong> {{date("Y-m-d",strtotime($book_results->book_date))}}<br/><strong>Netreach UID :</strong>{{$UID}}</td>                        
                    </tr>                   
                </table>
                <table>
                    <tr><th>Service Provider Name/Address</th><th> {{$book_results->center_name}}</th></tr>
                    <tr><td>Appointment Date</td><td>{{date('d F Y',strtotime($book_results->appoint_date))}}</td></tr>
                    <tr><th colspan="2">Type of Services selected </th></tr>
					@if(!empty($book_results->services_required))    
                    <tr><td colspan="3">
                    	<table>
                    		<tr>
							
								<?php 
									$servicesArr = json_decode($book_results->services_required); 
																	
									$services = array(
									"1"=>"HIV Test",
									"2"=>"STI Services",
									"3"=>"PrEP",
									"4"=>"PEP",
									"5"=>"Counselling on Mental Health",
									"6"=>"Referral to TI services",
									"7"=>"ART Linkages"
									);
										
									foreach($services as $key=>$value){
										
										if(!in_array($key,$servicesArr))
												continue;
										
								?>
                    			<td style="padding:15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 10px;"><?php echo $value; ?></td>
								<?php } ?>
                        		<!--<td style="padding: 10px 15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 10px;">Service 2</td>
                        		<td style="padding: 10px 15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 0 10px 0 0;">Service 3</td>-->
                    		</tr>
                    	</table>                        
                    </td></tr>
					@endif
                    @isset($vn_info)
                        <tr><th>Contact person for NETREACH (VN)</th><th>{{$vn_info->name}} {{$vn_info->last_name}} ({{$vn_info->mobile_number}})</th></tr>
                    @endisset
                </table>
				
				<table >
                    <tr>
                        <td>E-Referral Slip No: {{$book_results->e_referral_no}}</td>                        
                    </tr>
                </table>
                <!--<table>
                    <tr>
                        <td style="height: 100px;"></td>
                    </tr>
                </table>-->
                <!--<table>
                    <tr><td><p><strong>Terms & Condition</strong><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p></td></tr>
                </table>-->
                <!--<table style="border-top: 10px solid #146f98;">
                    <tr>
                        <td></td>                        
                    </tr>
                </table>-->
            </td>
        </tr>
    </table>    
</body>