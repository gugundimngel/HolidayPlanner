var requiredError = 'This field is required.';
var emailError = "Please enter the valid email address.";
var adultError = "DOB > 12 Years w.r.t. Travel Date";
var childError = "DOB, 2-12 Years w.r.t.Travel Date";
var infantError = "Valid Infant age should be under 2 years till the time of return flight last segment departure date.";
var captcha = "Captcha invalid.";
var maxError = "Number should be less than or equal to ";
var min = "This field should be greater than or equal to ";
var max = "This field should be less than or equal to ";
var equal = "This field should be equal to ";

function customValidate(formName,finalsubmit ='')
	{
		$("#loader").show(); //all form submit
		
		var i = 0;	
		$(".custom-error").remove(); //remove all errors when submit the button
		
		$("form[name="+formName+"] :input[data-valid]").each(function(){
			var dataValidation = $(this).attr('data-valid');
			var splitDataValidation = dataValidation.split(' ');
			
			var j = 0; //for serial wise errors shown	
			if($.inArray("required", splitDataValidation) !== -1) //for required
				{
					var for_class = $(this).attr('class');	
					
							if( !$.trim($(this).val()) ) 
								{
									i++;
									j++;
									$(this).after(errorDisplay(requiredError));  
								}
						
				}
			if(j <= 0)
				{
					if($.inArray("email", splitDataValidation) !== -1) //for email
						{
							if(!validateEmail($.trim($(this).val()))) 
								{
									i++;
									$(this).after(errorDisplay(emailError));  
								}
						}/* if($.inArray("GSTNumber", splitDataValidation) !== -1) //for email
						{
							if(!validateGSTNumber($.trim($(this).val()))) 
								{
									i++;
									$(this).after(errorDisplay('Please enter valid GST Number.'));  
								}
						} */
						if($.inArray("letteronly", splitDataValidation) !== -1) //for email
						{
							var newvalue = replacesp($.trim($(this).val()));
							if (!/^[a-z. ]+$/i.test($.trim($(this).val()))) {
								i++;
								$(this).after("<span class='custom-error' role='alert'>Letters only please</span>");  
							}
						}
						if($.inArray("minlength1", splitDataValidation) !== -1) //for email
						{
							var newvalue = $.trim($(this).val());
							var charLength = $(this).val().length;
							if(charLength < 1){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Enter minimum 1 Alphabets</span>");  
							}
						}
						if($.inArray("maxlength32", splitDataValidation) !== -1) //for email
						{
							var charLength = $(this).val().length;
							if(charLength > 32){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Enter maximum 32 Alphabets</span>");  
							}
						}
						if($.inArray("minlength2", splitDataValidation) !== -1) //for email
						{
							var charLength = $(this).val().length;
							if(charLength < 2){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Enter minimum 2 Alphabets</span>");  
							}
						}
						
						if($.inArray("minlength7", splitDataValidation) !== -1) //for email
						{
							var newvalue = $.trim($(this).val());
							var charLength = $(this).val().length;
							if(charLength < 7){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Please enter 7-15 digit mobile number.</span>");  
							}
						}
						if($.inArray("maxlength15", splitDataValidation) !== -1) //for email
						{
							var charLength = $(this).val().length;
							if(charLength > 15){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Please enter 7-15 digit mobile number.</span>");  
							}
						}
						if($.inArray("pasmaxlength15", splitDataValidation) !== -1) //for email
						{
							var charLength = $(this).val().length;
							if(charLength > 15){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Passport No cannot exceed 15 characters.</span>");  
							}
						}
						/* if($.inArray("NonMandtryPassportNoValidator", splitDataValidation) !== -1) //for email
						{
							var newvalue = $.trim($(this).val());
							if(!/^[a-zA-Z0-9]+$/i.test(newvalue)){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Passport Number must contain only letters and numbers.</span>");  
							}
						}if($.inArray("PassportNoValidator", splitDataValidation) !== -1) //for email
						{
							var newvalue = $.trim($(this).val());
							if(!/^[a-zA-Z0-9]+$/i.test(newvalue)){
								i++;
								$(this).after("<span class='custom-error' role='alert'>Passport Number must contain only letters and numbers.</span>");  
							}
						} */
						
					if($.inArray("adultdob", splitDataValidation) !== -1) //for email
						{
							 if ($.trim($(this).val()) != '') {
								now = new Date()
								var txtValue = $.trim($(this).val());
								if (txtValue != null)
									dob = txtValue.split('/');
								if (dob.length === 3) {
									 var dobday = dob[0];
									var dobMonth = dob[1];
									var dobYear = dob[2];
									var travelDate = $('#travelDate').val();
									var travelDateString = travelDate.split('-');
									var noOfMonths = Number(travelDateString[0] - dobYear) * 12 + Number(travelDateString[1] - dobMonth);
									var daydiff = Number((travelDateString[2] - dobday));
									var f = false;
									
									if (noOfMonths > 144) {
										f = true;
									} else if (noOfMonths == 144 && daydiff >= 0) {
										f = true;
									}
									if(!f){
										i++;
										$(this).after(errorDisplay(adultError));
									}
								}
							}
						}
					
						if($.inArray("childdob", splitDataValidation) !== -1) //for email
						{
							console.log($.trim($(this).val()));	
							 if ($.trim($(this).val()) != '') {
								now = new Date()
								var txtValue = $.trim($(this).val());
								if (txtValue != null)
									dob = txtValue.split('/');
								if (dob.length === 3) {
									 var dobday = dob[0];
									var dobMonth = dob[1];
									var dobYear = dob[2];
									var travelDate = $('#LastSegmentDepartureDate').val();
									var travelDateString = travelDate.split('-');
									 var daydiff = Number((travelDateString[2] - dobday));
									var monthdiff = Number(travelDateString[1] - dobMonth);
									var yeardiff = Number(travelDateString[0] - dobYear);
									if (daydiff < 0) { monthdiff = Number(monthdiff - 1); daydiff = Number(daydiff + 30); }
									if (monthdiff < 0) { yeardiff = Number(yeardiff - 1); monthdiff = Number(monthdiff + 12); }
									var noOfMonths = Number(yeardiff * 12 + monthdiff);
									var f = false;
									if (noOfMonths >= 24 && noOfMonths < 143) {
										f = true;
									}
									if (noOfMonths == 143 && daydiff < 31) {
										f = true;
									}
									if(!f){
										i++;
										$(this).after(errorDisplay(childError));
									}
									
									
								}
							}
						}	
			if($.inArray("infantdob", splitDataValidation) !== -1) //for email
						{
							 if ($.trim($(this).val()) != '') {
								now = new Date()
								var txtValue = $.trim($(this).val());
								if (txtValue != null)
									dob = txtValue.split('/');
								if (dob.length === 3) {
									  var dobday = dob[0];
									  var dobMonth = dob[1];
									   var dobYear = dob[2];
									  var lastSegmentDepartureDate = $('#LastSegmentDepartureDate').val();
									   var travelDateString = lastSegmentDepartureDate.split('-');
									   var today = new Date();
									var dd = today.getDate();
									var mm = today.getMonth() + 1; //January is 0!
									var yyyy = today.getFullYear();
									var tdaydiff = Number(dd - dobday);
									var tmonthdiff = Number(mm - dobMonth);
									var tmonthyear = Number(yyyy - dobYear);
									if (tmonthdiff < 0 && tmonthyear == 0) { i++;
										$(this).after(errorDisplay(infantError)); }
									if (tmonthdiff == 0 && tdaydiff < 0 && tmonthyear == 0) { i++;
										$(this).after(errorDisplay(infantError)); }
									var milisecondsInOneDay = 1000 * 60 * 60 * 24;

									var travelDate = new Date(travelDateString[0], travelDateString[1] - 1, travelDateString[2]);

									var infantToChildAge = new Date(Number(dobYear) + 2, dobMonth - 1, Number(dobday));

									var days = (travelDate - infantToChildAge) / milisecondsInOneDay;

									if (days >= 0) {
										i++;
										$(this).after(errorDisplay(infantError));
									}
	
								}
							}
						}	if($.inArray("PassDateValidator", splitDataValidation) !== -1) //for email
						{
							 if ($.trim($(this).val()) != '') {
								now = new Date()
								var txtValue = $.trim($(this).val());
								if (txtValue != null)
									dob = txtValue.split('/');
								if (dob.length === 3) {
									 var dobday = dob[0];
									  var dobMonth = dob[1];
									   var dobYear = dob[2];
									var travelDate = $('#travelDate').val();
								var travelDateString = travelDate.split('-');
									
								 var daydiff = parseInt(dobday) - parseInt(travelDateString[2]);
								var monthdiff = parseInt(dobMonth) - parseInt(travelDateString[1]);
								var yeardiff = parseInt(dobYear) - parseInt(travelDateString[0]);
									
									if (yeardiff > 0){
										i++;
								$(this).after(errorDisplay('Please enter a valid date'));
								}
									else if (yeardiff == 0 && monthdiff < 0){
										i++;
										$(this).after(errorDisplay('Please enter a valid date'));
									}
									else if (yeardiff == 0 && monthdiff == 0 && daydiff < 0){
										i++;
										$(this).after(errorDisplay('Please enter a valid date'));
									}
									else{
										
									}
										//return true;
	
								}
							}
						}						
					var forMin = splitDataValidation.find(a =>a.includes("min"));
					if(typeof forMin != 'undefined')
						{
							var breakMin = forMin.split('-');
							var digit = breakMin[1];

							var value = $.trim($(this).val()).length;
							if(value < digit) 
								{
									i++;
									$(this).after(errorDisplay(min+' '+digit+' character.'));  
								}	
						}
						
					var forMax = splitDataValidation.find(a =>a.includes("max"));
					if(typeof forMax != 'undefined')
						{
							var breakMax = forMax.split('-');
							var digit = breakMax[1];

							var value = $.trim($(this).val()).length;
							if(value > digit) 
								{
									i++;
									$(this).after(errorDisplay(max+' '+digit+' character.'));  
								}	
						}
						
					var forEqual = splitDataValidation.find(a =>a.includes("equal"));
					if(typeof forEqual != 'undefined')
						{
							var breakEqual = forEqual.split('-');
							var digit = breakEqual[1];

							var value = ($.trim($(this).val()).replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')).length;
							if(value != digit) 
								{
									i++;
									$(this).after(errorDisplay(equal+' '+digit+' character.'));  
								}	
						}
				}			
		});
		if(formName == 'add-signup'){
			
			if(!s){
				$('#password').after(errorDisplay('Password Must be strong'));
				i = i + 1;
			}
		}
		if(i > 0)
			{
				if(formName == 'add-query'){
					$('html, body').animate({scrollTop:$("#row_scroll"). offset(). top}, 'slow');
				}else if(formName == 'add-contact'){
					$('html, body').animate({scrollTop:$("#row_scroll"). offset(). top}, 'slow');
				}else if(formName != 'upload-answer')	{
					$('html, body').animate({scrollTop:0}, 'slow');
				}
				$("#loader").hide();
				return false;
			}	
		else
			{
				if(formName == 'add-query')
					{
						$('#preloader').show();
						$('#preloader div').show();
						var myform = document.getElementById('enquiryco');
						var fd = new FormData(myform);
						$.ajax({
							type:'post',
							url:$("form[name="+formName+"]").attr('action'),
							processData: false,
							contentType: false,
							data: fd,
							success: function(response){
								$('#preloader').hide();
								$('#preloader div').hide();
								var obj = $.parseJSON(response);
								if(obj.success){
									window.location = redirecturl;
								}else{
									$('.customerror').html(obj.message);
									$('html, body').animate({scrollTop:$("#row_scroll"). offset(). top}, 'slow');
								}
							}
						});
					}
					 else if(formName == 'frmProduct' && finalsubmit == '')
					{
						
						$(".pay_ticket").trigger('click');
						return true;	
					}
					else if(formName == 'queryform')
					{
						$('#preloader').show();
						$('#preloader div').show();
						var myform = document.getElementById('popenquiryco');
						var fd = new FormData(myform);
						$.ajax({
							type:'post',
							url:$("form[name="+formName+"]").attr('action'),
							processData: false,
							contentType: false,
							data: fd,
							success: function(response){
								$('#preloader').hide();
								$('#preloader div').hide();
								var obj = $.parseJSON(response);
								if(obj.success){
									window.location = redirecturl;
								}else{
									$('.customerror').html(obj.message);
									
								}
							}
						});
					}else if(formName == 'add-note')
					{   
						var myform = document.getElementById('addnoteform');
						var fd = new FormData(myform);
						$.ajax({
							type:'post',
							url:$("form[name="+formName+"]").attr('action'),
							processData: false,
							contentType: false,
							data: fd,
							success: function(response){
								$('#loader').hide(); 
								var obj = $.parseJSON(response);
								if(obj.success){
									$('#myAddnotes .modal-title').html('');
									$('#myAddnotes #note_type').html('');
									$('#myAddnotes').modal('hide');
									myfollowuplist(obj.leadid);
								}else{
									$('#myAddnotes .customerror').html('<span class="alert alert-danger">'+obj.message+'</span>');
									
								}
							}
						});
					}
				else if(formName == 'submit-review')
					{
						$("form[name=submit-review] :input[data-max]").each(function(){
							var data_max  = $(this).attr('data-max');
							var value = $.trim($(this).val());	
							if(parseInt(value) > parseInt(data_max))	
								{
									$(this).after(errorDisplay(maxError + data_max)); 
									$("#loader").hide();
									return false;	
								}
							else
								{
									$("form[name="+formName+"]").submit();
									return true;
								}	
						});	
					}
				else
					{	
					
							$("form[name="+formName+"]").submit();
							return true;
						
					} 
			}	
		
	}	
	

function customInvoiceValidate(formName, savetype)
	{
		$("#loader").show(); //all form submit
		
		var i = 0;	
		$(".custom-error").remove(); //remove all errors when submit the button
		$("#save_type").val(savetype);
		$("form[name="+formName+"] :input[data-valid]").each(function(){
			var dataValidation = $(this).attr('data-valid');
			var splitDataValidation = dataValidation.split(' ');
			
			var j = 0; //for serial wise errors shown	
			if($.inArray("required", splitDataValidation) !== -1) //for required
				{
					var for_class = $(this).attr('class');	
					if(for_class.indexOf('multiselect_subject') != -1)
						{
							var value = $.trim($(this).val());	
							if (value.length === 0) 
								{
									i++;
									j++;
									$(this).parent().after(errorDisplay(requiredError)); 
								}	
						} 
					else 
						{
							if( !$.trim($(this).val()) ) 
								{
									i++;
									j++;
									$(this).after(errorDisplay(requiredError));  
								}
						}
				}
			if(j <= 0)
				{
					if($.inArray("email", splitDataValidation) !== -1) //for email
						{
							if(!validateEmail($.trim($(this).val()))) 
								{
									i++;
									$(this).after(errorDisplay(emailError));  
								}
						}
						
							
					var forMin = splitDataValidation.find(a =>a.includes("min"));
					if(typeof forMin != 'undefined')
						{
							var breakMin = forMin.split('-');
							var digit = breakMin[1];

							var value = $.trim($(this).val()).length;
							if(value < digit) 
								{
									i++;
									$(this).after(errorDisplay(min+' '+digit+' character.'));  
								}	
						}
						
					var forMax = splitDataValidation.find(a =>a.includes("max"));
					if(typeof forMax != 'undefined')
						{
							var breakMax = forMax.split('-');
							var digit = breakMax[1];

							var value = $.trim($(this).val()).length;
							if(value > digit) 
								{
									i++;
									$(this).after(errorDisplay(max+' '+digit+' character.'));  
								}	
						}
						
					var forEqual = splitDataValidation.find(a =>a.includes("equal"));
					if(typeof forEqual != 'undefined')
						{
							var breakEqual = forEqual.split('-');
							var digit = breakEqual[1];

							var value = ($.trim($(this).val()).replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')).length;
							if(value != digit) 
								{
									i++;
									$(this).after(errorDisplay(equal+' '+digit+' character.'));  
								}	
						}
				}			
		});
		
		if(i > 0)
			{
				if(formName == 'add-query'){
					$('html, body').animate({scrollTop:$("#row_scroll"). offset(). top}, 'slow');
				}else if(formName != 'upload-answer')	{
					$('html, body').animate({scrollTop:0}, 'slow');
				}
				$("#loader").hide();
				return false;
			}	
		else
			{
				if(formName == 'add-query')
					{
						$('#preloader').show();
						$('#preloader div').show();
						var myform = document.getElementById('enquiryco');
						var fd = new FormData(myform);
						$.ajax({
							type:'post',
							url:$("form[name="+formName+"]").attr('action'),
							processData: false,
							contentType: false,
							data: fd,
							success: function(response){
								$('#preloader').hide();
								$('#preloader div').hide();
								var obj = $.parseJSON(response);
								if(obj.success){
									window.location = redirecturl;
								}else{
									$('.customerror').html(obj.message);
									$('html, body').animate({scrollTop:$("#row_scroll"). offset(). top}, 'slow');
								}
							}
						});
					}
				else
					{	
				
						$("form[name="+formName+"]").submit();
						return true;	
					} 
			}	
		
	}
	
function errorDisplay(error) {
	return "<span class='custom-error' role='alert'>"+error+"</span>";
}

function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
		return true;
	}
    else {
		return false;
    }
}

function replacesp(stringcom) {
        var comnewstr = '';
        for (var i = 0; i <= stringcom.length; i++) {
            if (i == 0) {
                comnewstr = stringcom.replace(',', '').replace(' ', '');
            }
            else {
                comnewstr = comnewstr.replace(',', '').replace(' ', '').replace('.', '');
            }
        }
        return comnewstr.replace(' ', '');
    }
	
	function validateGSTNumber(gstNumber) {
        var filter = /^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}/;
      
        if (filter.test(gstNumber)) {
            return true;
        }
        else {
            return false;
        }
    }