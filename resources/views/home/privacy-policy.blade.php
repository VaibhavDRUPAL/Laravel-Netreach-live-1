@extends('layouts.apphome')

@section('content') 

    <section class="landing-sec-1">
        <img src="{{asset('assets/img/web/slider-bg.jpg')}}" class="main-banner">
        <div class="banner-caption">
            <div class="container">
                <div class="row">
                 <div class="col-md-12">
                     <h1 class="heading1">NETREACH Privacy and Data Use Policy</h1>
					 <?php echo $content; ?>
                     <!--<p>Client confidentiality is extremely important at NETREACH. Our trained management, outreach and counselling staff carefully support clients and handle their information securely. Our clinical partners are NABL accredited (National accreditation Board for Testing and Calibration Laboratories) and follow the 2019 HIV Act to protect people living with HIV and the health information of people accessing HIV services. 
                    Here we explain what data may be collected on the NETREACH portal, how we use that data, and our protocol for protecting the confidentiality of our clients and their information:
                    </p><br>
                    <p><b>What information do I need to share with the NETREACH portal?</b></p><br>
                    <p>You will need to share some basic information on the portal on the  information with NETREACH’s to assess your HIV and sexual health needs and book services with our clinical partners.</p><br>
                    <p><b>Assessing your HIV and sexual health needs</b></p><br>
                    <p>We use the risk assessment form to receive HIV and sexual health service recommendations that are tailored to your needs. The risk assessment will ask questions about your HIV testing history, current HIV status and several factors that may impact your sexual health needs, like gender, sexuality, and several HIV risks factors. This information provides you with the most relevant service recommendations. We routinely use this data to help us ensure we reach all populations and improve our outreach and service delivery. Your responses on the risk assessment are kept STRICTLY confidential.</p><br>
                    <p><b>Booking services</b></p><br>
                    <p>Use the appointment booking feature to find HIV and sexual health services near you and book an appointment for a day that is convenient for you. By using the NETREACH portal you can book services at Government, private providers or NGO. When you book an appointment, you may share your GPS location (optional), Age (in years), Name or Nickname, Phone number, and the Services you would like to receive during your appointment. Your phone number enables us to provide Pre and Post-test HIV counselling and helps link you to any follow-up prevention or treatment services. If you enable location sharing with NETREACH portal our clinical service offerings will be prioritized to show you the nearest services first. If you refuse to share your location, you can simply choose your city and neighbourhood where you would like to find service offerings.</p><br>
                    <p><b>What information does NETREACH share with clinical providers?</b></p><br>
                    <p>NETREACH shares some information with clinical providers to help facilitate your appointment. This includes the information you enter to book an appointment on NETREACH like your Name/Nickname, Phone number, Services requested, Date and Time of appointment. This data is used to confirm your appointment and to verify when you reach the clinic. Your responses on the risk assessment are not shared with clinics.</p><br>
                    <p><b>What information do clinical partners share with NETREACH?</b></p><br>
                    <p>To facilitate secure data sharing and reporting, NETREACH signs a memorandum of understanding (an “agreement) with all our clinic partners which binds the clinics to maintain absolute confidentiality and treat client data with extreme sensitivity. This agreement allows us to share your appointment information with clinical partners and for clinical partners to securely report to NETREACH when you access services and report your diagnostic test results. The test results are secured at a password protected system and only accessed by a data manager for reporting and improving our services. It also ensures that we reach populations most in need of HIV services and ensure that follow-up prevention, testing and treatment services can be offered to every client requesting services on NETREACH. You can choose whether to share your diagnostic test results with the NETREACH counsellor during the post- test counselling call, which will help the counsellor to provide you relevant services and recommendations.</p><br>
                    <p><b>Added safeguards</b></p>
                    <div class="card-body" style="color: #075578;">
                        <ul>
                            <li>The NETREACH online client support team, including outreach workers and counsellors, are trained in client confidentiality and have signed and are bound to a code of ethics.</li>
                            <li>Clinical partners follow national accreditation for laboratory services and 2019 HIV Act.</li>
                            <li>Clinical partners have signed an agreement with NETREACH, that allows for data security and data sharing with NETREACH to protect clients of NETREACH.</li>
                            <li>NETREACH has collaborated with trained clinical partners on the provision of stigma-free services for NETREACH clients, including for key populations.</li>
                            <li>NETREACH collects feedback from clients about the clinical services they receive through NETREACH and shares this anonymous feedback with clinical partners to improve their service delivery.</li>
                            <li>Risk assessment responses are not shared with clinics.</li>
                            <li>HIV test results are not shared from clinical partners to the NETREACH client support team (outreach workers and counsellors). Clients can choose whether to disclose their HIV status or HIV test results with NETREACH counsellors to receive support services.</li>
                            <li>Netreach.co.in uses a range of security measures to protect clients using NETREACH and data stored on NETREACH, including using SQL, an encrypted server, password protected user logins.</li>
                        </ul>
                    </div>-->
                 </div><!-- col-md-6 -->
                </div><!--row-->
            </div><!--container-->
        </div><!--banner-caption-->
    </section><!--landing-sec-1-->
		
@endsection