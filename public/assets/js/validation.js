/* 
 * Created by Bhushan Singh
 * Dated: 16th Dec 2021
 * Purpose: Validation for All forms
 * Things to do. 
 *  1. Submit button id submit
 *  2. Use required class on all required elements
 *  3. Use Data-bind for regex to be applicable
 */
$(document).on('change', '.required', function (e) {
    var temp = '#' + $(this).attr('id');
    if ($.trim($(this).val()) != '')
    {
        $(this).removeClass("errborder");
        if ($(this).next().attr('class') == 'err')
        {
            $(this).next().remove();
        }
    } else
    {
        if (!$(this).next().hasClass('err'))
        {
            $(this).after("<div class='err'>*Required</div>");
        }
        $(this).addClass("errborder");
    }
});

hiv = {
    validate: function (message) {
        if (!message)
        {
            message = [];
        }
        var flag = 0;
        var flag1 = 0;
        var reg_match = [];
        reg_match['name'] = /^[a-zA-Z\s]+$/;
        reg_match['characterwithspace'] = /^[a-z . A-Z\s]+$/;
        reg_match['namewos'] = /^[a-zA-Z]+$/;
        reg_match['namewsp'] = /^[a-zA-Z0-9\s\.\-\_]+$/;
        reg_match['namewspwono'] = /^[a-zA-Z\s\.\-\_]+$/;
        reg_match['username'] = /^[a-zA-Z0-9\.\-\_]+$/;
        reg_match['text'] = /^[a-zA-Z0-9\-\s\,\.\']+$/;
        reg_match['alphanum'] = /^[a-zA-Z0-9]+$/;
        reg_match['content'] = /^[^\\\"<>|]+$/;
        reg_match['date'] = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
        reg_match['yearmonth'] = /^[0-9]{4}-(0[1-9]|1[0-2])$/;
        reg_match['year'] = /^[0-9]{4}$/;
        reg_match['datetime'] = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;
        reg_match['url'] = /^(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:/~+#-]*[\w@?^=%&amp;/~+#-])?$/;
        reg_match['time'] = /^(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;
        reg_match['number'] = /^\d+$/;
        reg_match['numnzero'] = /^[1-9]\d*/;
        reg_match['mobilenumber'] = /^\d{10}$/;
        reg_match['landline'] = /^\d{3,5}([-]*)\d{6,8}$/;
        reg_match['landlinenew'] = /^\d{11}$/;
        //reg_match['telephone'] = /^\d{6,30}$/;
        reg_match['pincode'] = /^\d{6}$/;
        reg_match['decimal'] = /^\s*-?[0-9]\d*(\.\d{1,2})?\s*$/;
        //reg_match['avarge']=/^[0-9][0-9]{1,10}(\.[0-9]{1,2})?$/;
        reg_match['dl'] = /^[ A-Za-z0-9\-\/]*$/;
        reg_match['garage'] = /^[ A-Za-z0-9\&\/\-\(\)\.\+]*$/;
        reg_match['remarks'] = /^[ A-Za-z0-9/\n/\r\&\,\/\-\(\)\.]*$/;
        reg_match['itemDesc'] = /^[ A-Za-z0-9/\n/\r\&\,\/\-\(\)\.\+\%_]*$/;
        reg_match['vemodel'] = /^([ A-Za-z0-9/.-])*$/;
        //reg_match['email']=/^.+@.+\..{2,3}$/
        reg_match['email'] = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        reg_match['emailnew'] = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;   // /^[a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
        reg_match['pubname'] = /^[ A-Za-z0-9\'\"&().-]*$/
        reg_match['pancard'] = /^(([A-Z]){5}([0-9]){4}([A-Z]){1})*$/
        reg_match['address'] = /^[ a-zA-Z0-9/\n/\r\'.,_@/()-:]*$/
        reg_match['comname'] = /^[ a-zA-Z0-9!\'\"#$%&()*,-./:;=?@\\_]*$/
        reg_match['cardno'] = /^[ a-zA-Z0-9\/\-\(\)]*$/
        reg_match['pnrno'] = /^([0-9-]{10,20})*$/
        reg_match['int'] = /^[0-9]\d*/
        reg_match['amount'] = /^\d+(\.\d{1,2})?$/
        reg_match['moduleurl'] = /^javascript\:void\(0\)|([a-z]+)\.php|((([a-z]+)\.php\?action=([a-zA-Z&=]+)))$/
        reg_match['particulars'] = /^([A-Za-z0-9\s\@\$\%\&\(\)\_\-\+\.\+\=\:])*$/
        reg_match['division'] = /^[a-zA-Z\s\-\_\,]*$/
        reg_match['bankalpha'] = /^[a-zA-Z\s\-\_\.]*$/
        reg_match['bankName'] = /^[a-zA-Z0-9\&\s\.\-\_]+$/
        reg_match['decimalVal'] = /^[0-9]+(\.[0-9]{1,2})?$/
        var err_msg = [];
        err_msg['name'] = "Should be Alphabets";
        err_msg['characterwithspace'] = "Should be Alphabets with . and space only";
        err_msg['namewspwono'] = "Should be Alphabets only";
        err_msg['namewos'] = "Should be Alphabets";
        err_msg['namewsp'] = "Should be Alphabets with _ - .";
        err_msg['username'] = "Should be Alphabets with . - _";
        err_msg['text'] = "Can contains alphanumberic";
        err_msg['alphanum'] = "can contain alphabets and numerics";
        err_msg['content'] = "Can\'t contains  \\ / :  < > \" | ";
        err_msg['date'] = "Should be date format (YYYY-MM-DD)";
        err_msg['datetime'] = "Date Time format (YYYY-MM-DD HH:MM:SS)";
        err_msg['yearmonth'] = "Year Month format (YYYY-MM)";
        err_msg['year'] = "Year format (YYYY)";
        err_msg['time'] = "Time format (HH:MM:SS)";
        err_msg['url'] = "Should be URL with http or https";
        err_msg['number'] = "Only Number Allowed";
        err_msg['numnzero'] = "Number must be greater then 0";
        err_msg['decimal'] = "Allow 2 digit decimal numbers";
        err_msg['mobilenumber'] = "Should be number and 10 digit.";
        err_msg['landline'] = "Should be Valid.(EX 011-12345678)";
        err_msg['landlinenew'] = "Should be Valid (EX 01112345678) and not more then 11 digit";
        err_msg['pincode'] = "Allow 6 digit numbers";
        err_msg['email'] = "Not Valid Email";
        err_msg['emailnew'] = "Not Valid Email";
        err_msg['pubname'] = "Can contain alphanumeric and ' \" . () -";
        err_msg['dl'] = "Please Enter Correct Value";
        err_msg['avarge'] = "Only decimal number allowed and should not more then 10 digit";
        err_msg['garage'] = "Can contain alphanumeric and & / - () . +";
        err_msg['remarks'] = "Can contain alphanumeric and ()-.,/ &";
        err_msg['itemDesc'] = "Can contain alphanumeric and ()-.,/ & + @ _%";
        err_msg['address'] = "Can contain alphanumeric and ' . , / () -: ";
        err_msg['pancard'] = "Plese Enter Correct Pan Card Format";
        err_msg['vemodel'] = "Can contain alphanumeric and / - .";
        err_msg['comname'] = "Can contain alphanumeric and ! \' \" # $ % & ( ) * , - . / : ; = ? @ \\ _";
        err_msg['cardno'] = "Can contain alphanumeric and \/ \- \(\)";
        err_msg['pnrno'] = "Can contain number and \-  minmum length 10";
        err_msg['int'] = "Can contain only number";
        err_msg['moduleurl'] = "Module Url Not Valid";
        err_msg['particulars'] = "Should  be Valid";
        err_msg['division'] = "Should be Valid";
        err_msg['bankName'] = "Should be Valid";
        err_msg['decimalVal'] = "Should be Valid";

        $(".err").each(function (index) {
            $(this).remove();
        });
        $(".errborder").each(function (index) {
            $(this).removeClass("errborder");
        });
        
        var login_type_flag =0;
        if($("#login_type_err").length > 0){
            if(!($("input[name='identify']:checked"). val()) && login_type_flag == 0 ){
                login_type_flag = 1;
                $("#login_type_err").after("<div class='err login_typ_err'>* Select at least one Option</div>");            
            }
        }
		var sexually_type_flag=0;
		if($("#sexually_err").length > 0){			
			 if(!($("input[name='sexually[]']:checked"). val()) && sexually_type_flag == 0 ){
                sexually_type_flag = 1;
                $("#sexually_err").after("<div class='err login_typ_err'>* Select at least one Option</div>");            
            }
		}
		
		
		var infection_type_flag=0;
		if($("#infection_err").length > 0){			
			 if(!($("input[name='hivinfection[]']:checked"). val()) && infection_type_flag == 0 ){
                infection_type_flag = 1;
                $("#infection_err").after("<div class='err login_typ_err'>* Select at least one Option</div>");            
            }
		}
		
		var services_type_flag=0;
		if($("#services_required_err").length > 0){			
			 if(!($("input[name='services[]']:checked"). val()) && services_type_flag == 0 ){
                services_type_flag = 1;
                $("#services_required_err").after("<div class='err login_typ_err'>* Select at least one Option</div>");            
            }
		}
		//return false;
		
        
        $('input, select, textarea, checkbox').each(function (index)
        {
            var tempflag = 0;
            var input = $(this);
            if (input.hasClass('required') && $.trim(input.val()) == '' && (input.is(':visible')==true))
            {
                tempflag = 1;
                flag = 1;
				console.log('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
                $(input).after("<div class='err'>*Required</div>");
                $(input).addClass("errborder");
            }
            if (input.attr('data-bind') && tempflag == 0)
            {   
                var str = input.val();
                var temp1 = new RegExp(reg_match[input.attr('data-bind')]);

                if ($.trim(str) != '')
                {
                    if (!temp1.test(str))
                    {
                        flag1 = 1;
                        if (input.attr('name') in message)
                        {
                            $(input).after("<div class='err'>*" + message[input.attr('name')] + ", " + err_msg[input.attr('data-bind')] + "</div>");
                        } else
                        {
                            var field_placeholder = input.attr('placeholder')!=undefined?input.attr('placeholder'):'';
                            $(input).after("<div class='err'>*Invalid " + field_placeholder + ", " + err_msg[input.attr('data-bind')] + "</div>");
                        }
                        $(input).addClass("errborder");
                        //console.log(input);
                    }
                }
            }
            if (input.attr('type') == 'file')
            {
                var file_selected = $(input).get(0).files;
                if ($(input).get(0).files && file_selected.length > 5)
                {
                    flag1 = 1;
                    $(input).after("<div class='err'>* You can select max 5 files</div>");
                    $(input).addClass("errborder");
                }
            }
			
			if(input.attr('data-bind')=="number"){
				
				if(input.val() < 18 ){
					flag1 = 1;
					$(input).after("<div class='err'>*  To take this survey you should be 18 and above</div>");
                    $(input).addClass("errborder");
				}else if(input.val()> 150){
					flag1 = 1;
					$(input).after("<div class='err'>*  To take this survey you should be 18 and above</div>");
                    $(input).addClass("errborder");
				}
			} 

        });
        if (flag == 1 || flag1 == 1 || login_type_flag == 1 || sexually_type_flag==1 || infection_type_flag==1 || services_type_flag==1)
        {
            return false;
        }
        //$("#submit").css('visibility','hidden');
        return true;
    },
    
    validatesaveasdraft: function (message) {
        if (!message)
        {
            message = [];
        }
        var flag = 0;
        var flag1 = 0;
        var reg_match = [];
        reg_match['name'] = /^[a-zA-Z\s]+$/;
        reg_match['characterwithspace'] = /^[a-z . A-Z\s]+$/;
        reg_match['namewos'] = /^[a-zA-Z]+$/;
        reg_match['namewsp'] = /^[a-zA-Z0-9\s\.\-\_]+$/;
        reg_match['namewspwono'] = /^[a-zA-Z\s\.\-\_]+$/;
        reg_match['username'] = /^[a-zA-Z0-9\.\-\_]+$/;
        reg_match['text'] = /^[a-zA-Z0-9\-\s\,\.\']+$/;
        reg_match['alphanum'] = /^[a-zA-Z0-9]+$/;
        reg_match['content'] = /^[^\\\"<>|]+$/;
        reg_match['date'] = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
        reg_match['yearmonth'] = /^[0-9]{4}-(0[1-9]|1[0-2])$/;
        reg_match['year'] = /^[0-9]{4}$/;
        reg_match['datetime'] = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;
        reg_match['url'] = /^(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:/~+#-]*[\w@?^=%&amp;/~+#-])?$/;
        reg_match['time'] = /^(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;
        reg_match['number'] = /^\d+$/;
        reg_match['numnzero'] = /^[1-9]\d*/;
        reg_match['mobilenumber'] = /^\d{10}$/;
        reg_match['landline'] = /^\d{3,5}([-]*)\d{6,8}$/;
        reg_match['landlinenew'] = /^\d{11}$/;
        //reg_match['telephone'] = /^\d{6,30}$/;
        reg_match['pincode'] = /^\d{6}$/;
        reg_match['decimal'] = /^\s*-?[0-9]\d*(\.\d{1,2})?\s*$/;
        //reg_match['avarge']=/^[0-9][0-9]{1,10}(\.[0-9]{1,2})?$/;
        reg_match['dl'] = /^[ A-Za-z0-9\-\/]*$/;
        reg_match['garage'] = /^[ A-Za-z0-9\&\/\-\(\)\.\+]*$/;
        reg_match['remarks'] = /^[ A-Za-z0-9/\n/\r\&\,\/\-\(\)\.]*$/;
        reg_match['itemDesc'] = /^[ A-Za-z0-9/\n/\r\&\,\/\-\(\)\.\+\%_]*$/;
        reg_match['vemodel'] = /^([ A-Za-z0-9/.-])*$/;
        //reg_match['email']=/^.+@.+\..{2,3}$/
        reg_match['email'] = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        reg_match['emailnew'] = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;   // /^[a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
        reg_match['pubname'] = /^[ A-Za-z0-9\'\"&().-]*$/
        reg_match['pancard'] = /^(([A-Z]){5}([0-9]){4}([A-Z]){1})*$/
        reg_match['address'] = /^[ a-zA-Z0-9/\n/\r\'.,/()-:]*$/
        reg_match['comname'] = /^[ a-zA-Z0-9!\'\"#$%&()*,-./:;=?@\\_]*$/
        reg_match['cardno'] = /^[ a-zA-Z0-9\/\-\(\)]*$/
        reg_match['pnrno'] = /^([0-9-]{10,20})*$/
        reg_match['int'] = /^[0-9]\d*/
        reg_match['amount'] = /^\d+(\.\d{1,2})?$/
        reg_match['moduleurl'] = /^javascript\:void\(0\)|([a-z]+)\.php|((([a-z]+)\.php\?action=([a-zA-Z&=]+)))$/
        reg_match['particulars'] = /^([A-Za-z0-9\s\@\$\%\&\(\)\_\-\+\.\+\=\:])*$/
        reg_match['division'] = /^[a-zA-Z\s\-\_\,]*$/
        reg_match['bankalpha'] = /^[a-zA-Z\s\-\_\.]*$/
        reg_match['bankName'] = /^[a-zA-Z0-9\&\s\.\-\_]+$/
        reg_match['decimalVal'] = /^[0-9]+(\.[0-9]{1,2})?$/
        var err_msg = [];
        err_msg['name'] = "Should be Alphabets";
        err_msg['characterwithspace'] = "Should be Alphabets  with . and space only";
        err_msg['namewspwono'] = "Should be Alphabets only";
        err_msg['namewos'] = "Should be Alphabets";
        err_msg['namewsp'] = "Should be Alphabets with _ - .";
        err_msg['username'] = "Should be Alphabets with . - _";
        err_msg['text'] = "Can contains alphanumberic";
        err_msg['alphanum'] = "can contain alphabets and numerics";
        err_msg['content'] = "Can\'t contains  \\ / :  < > \" | ";
        err_msg['date'] = "Should be date format (YYYY-MM-DD)";
        err_msg['datetime'] = "Date Time format (YYYY-MM-DD HH:MM:SS)";
        err_msg['yearmonth'] = "Year Month format (YYYY-MM)";
        err_msg['year'] = "Year format (YYYY)";
        err_msg['time'] = "Time format (HH:MM:SS)";
        err_msg['url'] = "Should be URL with http or https";
        err_msg['number'] = "Only Number Allowed";
        err_msg['numnzero'] = "Number must be greater then 0";
        err_msg['decimal'] = "Allow 2 digit decimal numbers";
        err_msg['mobilenumber'] = "Should be number and 10 digit.";
        err_msg['landline'] = "Should be Valid.(EX 011-12345678)";
        err_msg['landlinenew'] = "Should be Valid (EX 01112345678) and not more then 11 digit";
        err_msg['pincode'] = "Allow 6 digit numbers";
        err_msg['email'] = "Not Valid Email";
        err_msg['emailnew'] = "Not Valid Email";
        err_msg['pubname'] = "Can contain alphanumeric and ' \" . () -";
        err_msg['dl'] = "Please Enter Correct Value";
        err_msg['avarge'] = "Only decimal number allowed and should not more then 10 digit";
        err_msg['garage'] = "Can contain alphanumeric and & / - () . +";
        err_msg['remarks'] = "Can contain alphanumeric and ()-.,/ &";
        err_msg['itemDesc'] = "Can contain alphanumeric and ()-.,/ & + @ _%";
        err_msg['address'] = "Can contain alphanumeric and ' . , / () -: ";
        err_msg['pancard'] = "Plese Enter Correct Pan Card Format";
        err_msg['vemodel'] = "Can contain alphanumeric and / - .";
        err_msg['comname'] = "Can contain alphanumeric and ! \' \" # $ % & ( ) * , - . / : ; = ? @ \\ _";
        err_msg['cardno'] = "Can contain alphanumeric and \/ \- \(\)";
        err_msg['pnrno'] = "Can contain number and \-  minmum length 10";
        err_msg['int'] = "Can contain only number";
        err_msg['moduleurl'] = "Module Url Not Valid";
        err_msg['particulars'] = "Should  be Valid";
        err_msg['division'] = "Should be Valid";
        err_msg['bankName'] = "Should be Valid";
        err_msg['decimalVal'] = "Should be Valid";

        $(".err").each(function (index) {
            $(this).remove();
        });
        $(".errborder").each(function (index) {
            $(this).removeClass("errborder");
        });
        $('input, select, textarea, checkbox').each(function (index)
        {            
            var tempflag = 0;
            var input = $(this);
            
            if (input.attr('data-bind') && tempflag == 0 && $.trim(input.val()) != '')
            {   
                var str = input.val();
                var temp1 = new RegExp(reg_match[input.attr('data-bind')]);

                if ($.trim(str) != '')
                {
                    if (!temp1.test(str))
                    {
                        flag1 = 1;
                        if (input.attr('name') in message)
                        {
                            $(input).after("<div class='err'>*" + message[input.attr('name')] + ", " + err_msg[input.attr('data-bind')] + "</div>");
                        } else
                        {
                            var field_placeholder = input.attr('placeholder')!=undefined?input.attr('placeholder'):'';
                            $(input).after("<div class='err'>*Invalid " + field_placeholder + ", " + err_msg[input.attr('data-bind')] + "</div>");
                        }
                        $(input).addClass("errborder");
//                        console.log(input);
                    }
                }
            }
            if (input.attr('type') == 'file')
            {
                var file_selected = $(input).get(0).files;
                if ($(input).get(0).files && file_selected.length > 5)
                {
                    flag1 = 1;
                    $(input).after("<div class='err'>* You can select max 5 files</div>");
                    $(input).addClass("errborder");
                }
            }

        });
        if (flag == 1 || flag1 == 1)
        {
            return false;
        }
        //$("#submit").css('visibility','hidden');
        return true;
    }
}