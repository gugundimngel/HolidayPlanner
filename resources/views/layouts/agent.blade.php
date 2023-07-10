<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="./">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keyword" content="E-Weblink CRM">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="shortcut icon" type="image/png" href="{!! asset('public/images/favicon.png') !!}"/>
		<title> Holiday Package  | @yield('title')</title> 
		<!-- Font Awesome -->
	  <link rel="stylesheet" href="{{URL::asset('public/icons/font-awesome/css/all.min.css')}}">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	  <!-- Datatable -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/dataTables.bootstrap4.css')}}">
	  <!-- Tempusdominus Bbootstrap 4 -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/tempusdominus-bootstrap-4.min.css')}}">
	  <!-- iCheck -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/icheck-bootstrap.min.css')}}">
	  <!-- Select2 -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/select2.min.css')}}">
	  <link rel="stylesheet" href="{{URL::asset('public/css/select2-bootstrap4.min.css')}}">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/admintheme.min.css')}}">
	  <!-- overlayScrollbars -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/OverlayScrollbars.min.css')}}">
	  <!-- Daterange picker -->
	 <!--<link rel="stylesheet" href="{{URL::asset('public/css/daterangepicker.css')}}">-->
		<link rel="stylesheet" href="{{URL::asset('public/css/daterangepicker-bs3.css')}}">
	<!--	<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/datepicker3.css')}}" >-->
	  <link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/bootstrap-select.min.css')}}" >
	  <!-- summernote -->
	  <link rel="stylesheet" href="{{URL::asset('public/css/summernote-bs4.css')}}"> 
	  <!-- style --> 
	  <link rel="stylesheet" href="{{URL::asset('public/css/flags.css')}}">
	  <link rel="stylesheet" href="{{URL::asset('public/css/style.css')}}">
	  <link rel="stylesheet" href="{{URL::asset('public/css/agentstyle.css')}}">
	  <link rel="stylesheet" href="{{URL::asset('public/css/font-awesome.min.css')}}">
	 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	 <link rel="stylesheet" href="{{URL::asset('public/css/niceCountryInput.css')}}">
	 <link rel="stylesheet" href="{{URL::asset('public/css/owl.carousel.min.css')}}">
	  <!-- Google Font: Source Sans Pro -->
	  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
		<!-- jQuery -->
		<script src="{{URL::asset('public/js/jquery.min.js')}}"></script>	 
		<script>var billingdata = new Array();</script>	 
		
	<style>
        .upic > img {
            width: 32px;
            height: auto;
            float: left;
        }
        .margin-r-10{
            margin-right:10px
            }
        .margin-r-20{
            margin-right:20px
        }

        .ps_btn {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            color: #666666;
            padding: 5px 8px;
        }

	.dnone{display:none}
	.f18{font-size:18px;}
	.mt{margin-top:5px;}
	.btn-arrow-right {
	position: relative;
	padding-left: 18px;
	padding-right: 18px;}
	.btn-arrow-right {padding-left: 36px;}
	.btn-arrow-right:before,
	.btn-arrow-right:after{
		content:"";
		position: absolute;
		top: 5px;
		width: 22px;
		height: 22px;
		background: inherit;
		border: inherit;
		border-left-color: transparent;
		border-bottom-color: transparent;
		border-radius: 0px 4px 0px 0px;
		-webkit-border-radius: 0px 4px 0px 0px;
		-moz-border-radius: 0px 4px 0px 0px;}
	.btn-arrow-right:before,
	.btn-arrow-right:after {
		transform: rotate(45deg);
		-webkit-transform: rotate(45deg);
		-moz-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		-ms-transform: rotate(45deg);}
	.btn-arrow-right:before {left: -11px;}
	.btn-arrow-right:after {right: -11px;}
	.btn-arrow-right:after { z-index: 1;}
	.btn-arrow-right:before{ background-color: white;}
	.text-ellipsis{white-space: nowrap; text-overflow: ellipsis; overflow: hidden;}
	

	.dispM{display:block}
	.ww40{width:40%}
	.logo{display:block}
	.sear01{width:60%}
	.lh24{line-height:24px}.lh28{line-height:28px}.lin_drp a{color:#333}
	
	@media only screen and (max-width:479px)
        {
            .dispM{display:none}
            .ww40{width:100%}
			.logo{display:none!important}
			.sear01{width:100%; border:none;-webkit-box-shadow:none}
		}
		
        blockquote {
            font-size : 14px; 
        }
        .popover {max-width:700px;}
        .selec_reg{background-color:#f4f4f4; border:1px solid #ddd; color:#444; border-radius: 3px; font-size:12px}
        .selec_reg option{background-color:#fff; color:#444; padding:5px; cursor:pointer;}
        .f13{font-size:13px}
        .attch_downl a{width:270px; display:block; float:left; margin-bottom:8px; margin-right:20px}
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: local('Material Icons'), local('MaterialIcons-Regular'), url(https://fonts.gstatic.com/s/materialicons/v21/2fcrYFNaTjcS6g4U3t-Y5ZjZjT5FdEJ140U2DJYC3mY.woff2) format('woff2');
        }

        .material-icons {
            font-family: 'Material Icons';
            -moz-font-feature-settings: 'liga';
            -moz-osx-font-smoothing: grayscale;
        }
        .qr_btn{padding:2px 10px 3px; border-radius:15px; cursor:pointer}
    
    </style>	
		   
	</head>
	<body class="hold-transition sidebar-mini layout-fixed loderover">
	
		<div class="wrapper">
		<div id="loader">
			<div class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div> 
        </div>
			<!--Header-->
			@include('../Elements/Agent/header')
		
			<!--Content-->
			<div class="app-body">
				<!--Left Side Bar-->
				@include('../Elements/Agent/left-side-bar')
				
				@yield('content')
				
			</div>
			<!--Footer-->
			@include('../Elements/Agent/footer')
		</div>	
		<div class="modal fade" id="leadsearch_modal">
			<div class="modal-dialog modal-lg">
			  <div class="modal-content">
				<div class="modal-header">
				  <h4 class="modal-title">Lead Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<form action="{{route('admin.leads.index')}}" method="get">
				<div class="modal-body"> 
					
						<div class="row">
							<div class="col-md-6">
								<div class="form-group row">
									<label for="lead_id" class="col-sm-2 col-form-label">Lead ID</label>
									<div class="col-sm-10">
										{{ Form::text('lead_id', Request::get('lead_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Lead ID', 'id' => 'lead_id' )) }}	 						
										@if ($errors->has('lead_id'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('lead_id') }}</strong>
											</span> 
										@endif
								   </div>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="name" class="col-sm-2 col-form-label">Name</label>
									<div class="col-sm-10">
										{{ Form::text('name', Request::get('name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Name', 'id' => 'name' )) }}	 						
										@if ($errors->has('name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('name') }}</strong>
											</span> 
										@endif
								   </div>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										{{ Form::text('email', Request::get('email'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Email', 'id' => 'email' )) }}	 						
										@if ($errors->has('email'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('email') }}</strong>
											</span> 
										@endif
								   </div>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="phone" class="col-sm-2 col-form-label">Phone</label>
									<div class="col-sm-10">
										{{ Form::text('phone', Request::get('phone'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Phone', 'id' => 'phone' )) }}	 						
										@if ($errors->has('phone'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('phone') }}</strong>
											</span> 
										@endif
								   </div>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="followupdate" class="col-sm-2 col-form-label">Followup Date</label>
									<div class="col-sm-10">
										{{ Form::text('followupdate', Request::get('followupdate'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Followup Date', 'id' => 'followupdate' )) }}	 						
										@if ($errors->has('followupdate'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('followupdate') }}</strong>
											</span> 
										@endif
								   </div>	
								</div>
							</div>
							
							
						</div>
					
				</div>
				<div class="modal-footer justify-content-between">
				  <a href="{{route('admin.leads.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
				</form>	
			  </div>
			  <!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->	
		<div class="customer_support">
			<a href="javascript:;" data-toggle="modal" data-target="#contactsupport_modal" class="btn btn-primary"><i class="fa fa-envelope"></i> Contact Support</a>
		</div>
		<div class="modal fade" id="contactsupport_modal">
			<div class="modal-dialog modal-lg">
			  <div class="modal-content">
				<div class="modal-header">
				  <h4 class="modal-title">At Your Service</h4>
				  <p>Responses to this email will be sent to info@eweblink.net</p>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="subject" class="col-form-label">Subject</label>
									{{ Form::text('subject', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Subject', 'id' => 'subject' )) }}	 						
									@if ($errors->has('subject'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('subject') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label for="how_help_you" class="col-form-label">How can we help you today?</label>
									{{ Form::text('how_help_you', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'How can we help you today?', 'id' => 'how_help_you' )) }}	 						
									@if ($errors->has('how_help_you'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('how_help_you') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label for="attach_file" class="col-form-label">Attachments <i class="fa fa-explanation"></i></label>
									<input type="file" name="attach_file" class="" autocomplete="off" data-valid="" style="display:block;" />
									@if ($errors->has('attach_file'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('attach_file') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label for="contact_no" class="col-form-label">Contact Number</label>
									{{ Form::text('contact_no', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Contact Number', 'id' => 'contact_no' )) }}	 						
									@if ($errors->has('contact_no'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('contact_no') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label for="critical_request" class="col-form-label">How critical is your request?</label>
									<select name="critical_request" data-valid="required" id="critical_request" class="form-control" autocomplete="new-password">
										<option value="None">None</option>
										<option value="Just FYI">Just FYI</option>
										<option value="Nothing urgent, can wait">Nothing urgent, can wait</option>
										<option value="I'm stuck, need assistance">I'm stuck, need assistance</option>
									</select>	 						
									@if ($errors->has('critical_request'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('critical_request') }}</strong>
										</span> 
									@endif
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="button" id="support_save" class="btn btn-primary">Save</button>
				</div>
			  </div>
			  <!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		
		<!-- jQuery UI 1.11.4 -->
		
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		
		<!-- Bootstrap 4 -->
		<script src="{{URL::asset('public/js/bootstrap.bundle.min.js')}}"></script>	
		<!-- Datatable  -->
		<script src="{{URL::asset('public/js/jquery.dataTables.js')}}"></script>	
		<script src="{{URL::asset('public/js/dataTables.bootstrap4.js')}}"></script>
		<!-- Select2 -->		
		<!--<script src="{{URL::asset('public/js/select2.full.min.js')}}"></script>	-->
		<!-- Select2 -->		
		<script src="{{URL::asset('public/js/select2.min.js')}}"></script>			
		<!-- daterangepicker -->
		<script src="{{URL::asset('public/js/moment.min.js')}}"></script>
		<script src="{{URL::asset('public/js/daterangepicker.js')}}"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="{{URL::asset('public/js/tempusdominus-bootstrap-4.min.js')}}"></script>
		<!-- Summernote -->
		<script src="{{URL::asset('public/js/summernote-bs4.min.js')}}"></script>
		
		<!-- overlayScrollbars -->
		<script src="{{URL::asset('public/js/jquery.overlayScrollbars.min.js')}}"></script>
		<!-- Admin Theme App -->
		<script src="{{URL::asset('public/js/admintheme.min.js')}}"></script>
		<!-- Admin Theme dashboard demo (This is only for demo purposes) -->
		<script src="{{URL::asset('public/js/dashboard.js')}}"></script>
		<!-- Admin Theme for demo purposes -->
		<script src="{{URL::asset('public/js/demo.js')}}"></script>
		<script src="{{URL::asset('public/js/custom.js')}}"></script>
		<script src="{{URL::asset('public/js/custom-form-validation.js')}}"></script>
		<script src="{{URL::asset('public/js/fileupload.js')}}"></script>
		<!-- Bootstrap Switch -->
		<script src="{{URL::asset('public/js/bootstrap-switch.min.js')}}"></script>
		<!--<script src="{{URL::asset('public/js/jquery.flagstrap.js')}}"></script>-->
		<script src="{{URL::asset('public/js/custom-datatable.js')}}"></script>
		<script src="{{URL::asset('public/js/jquery.inputmask.js')}}"></script>
		<script src="{{URL::asset('public/js/jquery.inputmask.extensions.js')}}"></script>
		<script src="{{URL::asset('public/js/bootstrap-datepicker.js')}}"></script>
		<script src="{{URL::asset('public/js/bootstrap-timepicker.min.js')}}"></script>
		<script language="javascript" src="{{URL::asset('public/js/common.js')}}"></script> 
		<script language="javascript" src="{{URL::asset('public/js/sessionpopup.js')}}"></script> 
		
		<!--<script src="{{URL::asset('public/js/custom-popover.js')}}"></script>   -->
		<script src="{{URL::asset('public/js/popover.js')}}"></script>   
		<script src="{{URL::asset('public/js/Chart.min.js')}}"></script>   
		<script src="{{URL::asset('public/js/dashboard2.js')}}"></script>   
		<script src="{{URL::asset('public/js/owl.carousel.js')}}"></script>   
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="{{URL::asset('public/js/niceCountryInput.js')}}"></script> 
		<script type="text/javascript">
			var site_url = "<?php echo URL::to('/'); ?>"; 
			var media_url = "<?php echo route('admin.media.store'); ?>";
			var media_index_url = "<?php echo route('admin.media.index'); ?>";
			var media_remove_url = "<?php echo route('admin.media.delete'); ?>";
			var media_image_url = "<?php echo URL::to('/public/img/media_gallery'); ?>";
			var followuplist = "<?php echo URL::to('/'); ?>";
			var followupstore = "<?php echo URL::to('/admin/followup/store'); ?>";
		</script>
		<!--<script async src="https://app.appzi.io/bootstrap/bundle.js?token=unZ6A"></script><div id="zbwid-3c79022e"></div>-->
		<script>  
		
			// $('#basic').flagStrap();
			/* function onChangeCallback(ctr){
				console.log("The country was changed: " + ctr);
				//$("#selectionSpan").text(ctr);
			}*/
			$(document).ready(function () {
				$('.agent_offer_carousel').owlCarousel({ 
	loop:true,
	margin:10,
	nav:true,
	navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
	dots:false,
	autoplay:true,
	autoplayTimeout:2500,
	autoplayHoverPause:true,
	responsive:{
		0:{
			items:1
		},
		480:{
			items:2
		},
		1000:{
			items:3
		} 
	}
});
				$(document).delegate('.balance_refresh', 'click', function(){
					$('.balance_refresh i').addClass('fa-spin');
					$.ajax({
						url: '{{URL::to('/agent/balance_refresh')}}',
						type: 'GET',
						success: function(response){
								$('.balance_refresh i').removeClass('fa-spin');
							$('.newbalnace').html(response);
						}
					});
				});
				$(document).delegate('.credit_refresh', 'click', function(){
					$('.credit_refresh i').addClass('fa-spin');
					$.ajax({
						url: '{{URL::to('/agent/credit_refresh')}}',
						type: 'GET',
						success: function(response){
							$('.credit_refresh i').removeClass('fa-spin');
							$('.newcredit').html(response);
						}
					});
				});
				$(".niceCountryInputSelector").each(function(i,e){
					new NiceCountryInput(e).init();
				});
			});    
		
		  $(function () { 
		  $('.assignlead_modal').on('click', function(){
			  var val = $(this).attr('mleadid');
			  $('#assignlead_modal #mlead_id').val(val);
			  $('#assignlead_modal').modal('show');
		  });
			  $('.datepicker').daterangepicker({				 
				  singleDatePicker: true
				//showDropdowns: true,
			 });
			  $('#fromdate').datepicker({				 
				  singleDatePicker: true
				//showDropdowns: true,
			 }); $('#todate').datepicker({				 
				  singleDatePicker: true
				//showDropdowns: true,
			 });
			 //Initialize Select2 Elements
			$('.select2').select2();
	
		
				
		function initializeSelect2(selectElementObj) {
			console.log(selectElementObj);
			selectElementObj.select2({
				tags: true,
				placeholder: "Type or click to select an item",
				});
		}
			$(".select2dat").each(function() {
      initializeSelect2($(this));
    });
	$(document).delegate('#add_new_row','click', function(){
		var clonedval = $('.item_row').html();
		$('#itemsdetail tbody').append('<tr class="tr_clone">'+clonedval+'</tr>');
		  //$('.select2dat').select2({tags: true});
		 //  var newSelect=$('#itemsdetail').closest("tr").find(".select2dat");
		   var newSelect=$("#itemsdetail").find(".select2dat").last();
  initializeSelect2(newSelect);
		 $('.select2dat').last().next().next().remove();
		  
	});
	$(document).delegate('.item_clone','click', function(){
		var $tr    = $(this).closest('.tr_clone');
		var $clone = $tr.clone();
		
		$tr.after($clone);
		var div = $("#itemsdetail tr"); 
		 div.find(".select2dat").each(function(index)
    {
        if ($(this).data('select2dat')) {
            $(this).select2('destroy');
          } 
    });
	 $('.select2dat').select2(); 
	 $('.select2dat').last().next().next().remove();
		/* 
		  var newSelect=$('#itemsdetail').find(".select2dat");
			initializeSelect2(newSelect);
			$('.select2dat').last().next().next().remove(); */
	});
	
	$(document).delegate('.item_remove','click', function(){
		var $tr    = $(this).closest('.tr_clone');
		var trclone = $('.tr_clone').length;
		
		if(trclone > 1){
			$tr.remove();
		}
		calculatefinaltotals(); 
	});
	
	function calculatefinaltotals(){
	 var item_quantity = 0;
	 var unit_price = 0;
	 var total_value = 0;
	 var subtotal = 0;
	 var finaltotal = 0.00;
	
	$('.tr_clone').each(function(){
		  item_quantity = parseFloat($(this).find(".qty").val());
         unit_price = parseFloat($(this).find(".rate").val());
		 total_value = unit_price * item_quantity;
         subtotal += total_value;
		 console.log(unit_price);
	});
	var tax = $("input[name='tax']:checked"). val();
	var discount = $('.discount').val();
	var discounttype = $('.disc_type').val();
	if(discounttype == 'fixed'){
		
		var per = discount;
		finaltotal = subtotal - parseFloat(discount);
		 
	}else {
		console.log('dsdds'); 
		var per = (subtotal * discount) / 100;
		finaltotal = subtotal - per;
	}
	
	if(tax != 0){
		console.log(tax);
		var taxname = $("input[name='tax']:checked"). attr('ratename');
		var taxrate = $("input[name='tax']:checked"). attr('ratetax');
		var taxcal = (finaltotal * taxrate) / 100;
		$('.taxdetail').show();
		$('.taxdetail .taxname').html(taxname+' ['+taxrate+']%');
		$('.taxdetail .taxprice').html(taxcal.toFixed($('#dec_type').val()));
	}else{
		$('.taxdetail').hide();
		$('.taxdetail .taxname').html('');
		var taxcal = 0;
	}
	
	finaltotal = finaltotal + parseFloat(taxcal);
	$('.subtotal').html(subtotal.toFixed($('#dec_type').val()));
	
	$('.discountsho').html(per);
	console.log(finaltotal+'sddd');
	$('.finaltotal').html(finaltotal.toFixed($('#dec_type').val()));
}

			//Initialize Select2 Elements
			$('.select2bs4').select2({
			  theme: 'bootstrap4'
			}) 
			// Summernote
			$('.textarea').summernote();
			
			 $("input[data-bootstrap-switch]").each(function(){
			  $(this).bootstrapSwitch('state', $(this).prop('checked'));
			});
			
		  });
		  function getLocations(){
			  var dest_type = $('#dest_type option:selected').val();
			  $.ajax({
				 url:"{{route('getDestinations')}}",
				 type: 'get', 
				 data:{destype:dest_type},
				 success: function(response){
					 $('#destination').html(response);
				 }
				
			  });
		  }
		  function getPackages(){
			  
			  var dest_type = $('#destination option:selected').val();
			  $.ajax({
				 url:"{{route('getPackages')}}",
				 type: 'get', 
				 data:{destination:dest_type},
				 success: function(response){
					 $('#sortabledata').html(response);
					  var LI_POSITION = 'li_position';
       $('ul#sortable').sortable({
         //observe the update event...
            update: function(event, ui) {
              //create the array that hold the positions...
              var a = []; 
                //loop trought each li...
               $('#sortable li').each( function(e) {
				   
					a.push($(this).attr('id') + ':' + ( $(this).index() + 1 ));
              });
				var s = a.join(',');
				$('#order_sort').val(s);
            }
        });
				 }
				
			  });
		  }
		  function getHotelLocations(){
			  var dest_type = $('#dest_type_pack option:selected').val();
			  $.ajax({
				 url:"{{route('getDestinations')}}",
				 type: 'get', 
				 data:{destype:dest_type},    
				 success: function(response){
					 $('#destination_pack').html(response);  
					 $('#hotel_name').html('<option value="">Choose One...</option>'); 
				 }
				
			  });
		  }
		  function getHotelNames(){ 
			  var destination = $('#destination_pack option:selected').val();
			  $.ajax({
				 url:"{{route('getHotels')}}",
				 type: 'get', 
				 data:{desnate:destination},    
				 success: function(response){
					 $('#hotel_name').html(response);  
				 } 
				  
			  });
		  }
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip();
			   $('[data-toggle="popover"]').popover();
			});
			
		</script>
		<script>
        //Date range as a button
        $(function () {
            var fromreload = '';
            var ddate = '';
            if (fromreload == '1') {
                var stdate = '';
                var eddate = '';


                var start = moment(stdate);
                var end = moment(eddate);

                function cb(start, end) {
                    $('#daterange-btn span').html(start.format('DD MMM YY') + ' - ' + end.format('DD MMM YY'));
                }
            }
						else if (fromreload == '2') {
							var stdate = '';
							var start = moment(stdate);
							var end = moment(eddate);
							function cb(start, end) {
									$('#daterange-btn span').html(start.format('DD MMM YY') + ' - ' + end.format('DD MMM YY'));
							}
						}
            else {
                var start = moment().subtract('2708', 'days');
                var end = moment();

                function cb(start, end) {
                    $('#daterange-btn span').html(start.format('DD MMM YY') + ' - ' + end.format('DD MMM YY'));
                }
            }
            $('#daterange-btn').daterangepicker({

                    ranges: {
                        'All Time': [moment().subtract('2708', 'days'), moment()],
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: start,
                    endDate: end,
                },
                function (start, end) {
                    cb(start, end);
                }, cb
            );
            cb(start, end);

        });
    </script>

		<script>
		

			<!-- Page script -->
			function validatenum(e) {
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					// Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) ||
					// Allow: Ctrl+C
					(e.keyCode == 67 && e.ctrlKey === true) ||
					// Allow: Ctrl+X
					(e.keyCode == 88 && e.ctrlKey === true) ||
					// Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			}
			
			 $("#domestic_to").select2({
		tags: true,
        tokenSeparators: ['/', ',', ';']
    });
    $("#domestic_from").select2({
                tags: true,
        tokenSeparators: ['/', ',', ';']

    });
    $("#Plcity").select2({

		tags: true,
        tokenSeparators: ['/', ',', ';']
    });
//    $("#Hlcity").select2({
//
//		tags: true,
//        tokenSeparators: ['/', ',', ';']
//    });
    $("#glcity2").select2({

		tags: true,
        tokenSeparators: ['/', ',', ';']
    });

    $("#lcity2").select2({

		tags: true,
        tokenSeparators: ['/', ',', ';']
    });
    $(".check_theme").select2({

        tokenSeparators: ['/', ',', ';']
    });
    $("#agent_access_url").select2();
    $("#agent_noaccess_url").select2();
    
        
    $(function () {


        if (window.location.search.indexOf("&fiter_str=") > -1) {
            var filter_url = window.location.search.split("&fiter_str=");

            var selectedValues = filter_url[1].split(',');
            console.log(selectedValues);
            for (var i = 0; i < selectedValues.length; i++) {
                $("#filter_by option[value='" + selectedValues[i] + "']").attr("selected", "selected");
            }
            $("#filter_by").trigger('change');
        }

//                 var start = moment().subtract('2708', 'days');
//                             var end = moment();
        //Datemask dd/mm/yyyy
        /* $("#datemask").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        }); */
        //Datemask2 mm/dd/yyyy
        /* $("#datemask2").inputmask("mm/dd/yyyy", {
            "placeholder": "mm/dd/yyyy"
        }); */
        //Money Euro
       /*  $("[data-mask]").inputmask();
        if (formedit !== "") {
            var calstartDate = "";
            var calminDate = "";
            var calendDate = "";
        }
        else {

            var calstartDate = moment();
            var calminDate = moment();
            var calendDate = "";
        }
 */

        //HOTE PACKAGE
       /*   $('#reservation3').daterangepicker({

            startDate: calstartDate,
            minDate: calminDate,
            endDate: calendDate


        });
        //private date range picker
        $('#reservation1').daterangepicker({
            startDate: calstartDate,
            minDate: calminDate,
            endDate: calendDate
        });

        //group date range picker
        $('#reservation').daterangepicker({
            startDate: calstartDate,
            minDate: calminDate,
            endDate: calendDate

        });
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
        });  */

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
        //Date picker
        var date = new Date();
        date.setDate(date.getDate() - 0);
        $('#datepicker').datepicker({
            autoclose: true,
            startDate: date
        });
		
		$('#followupdate').datepicker({
           autoclose: true,
        });
		
		$('.commodate').datepicker({
           autoclose: true,
		   format: 'yyyy-mm-dd'
        });
		$('.commodategst').datepicker({
           autoclose: true,
		   format: 'dd/mm/yyyy'
        });
		$('.commondate').datepicker({
           autoclose: true,
		   format: 'mm/dd/yyyy'
        });
        $('#datepicker').datepicker().on('changeDate', function (ev) {


            var enddate = ev.date.toString();
            var ck_end = enddate.split('GMT');
            var date = new Date(ck_end[0]);
            var end_month = date.getMonth() + 1;
            if (end_month < 10) {
                end_month = "0" + end_month;
            }
            var end_year = date.getFullYear();
            var end_date = date.getDate();
            if (end_date < 10) {
                end_date = "0" + end_date;
            }
            var date = new Date();
            date.setDate(date.getDate() - 0);
            var newstartdat = date.toString();
            var ck_start = newstartdat.split('GMT');
            var date = new Date(ck_start[0]);
            var start_month = date.getMonth() + 1;
            if (start_month < 10) {
                start_month = "0" + start_month;
            }
            var start_year = date.getFullYear();
            var start_date = date.getDate();
            if (start_date < 10) {
                start_date = "0" + start_date;
            }

            var eddatediv = end_date + '/' + end_month + '/' + end_year;
            var stdatediv = start_date + '/' + start_month + '/' + start_year;
            if (form_type == 1) {
                $("#gstartdate").html(" &nbsp; " + eddatediv + " &nbsp;");
                $("#reservation").val(stdatediv + "-" + eddatediv);
                $('#reservation').daterangepicker({

                    startDate: stdatediv,
                    minDate: stdatediv,
                    endDate: eddatediv


                });
            }

        });

       
    }); 

    $(".dropdown-menu li a").click(function () {
        $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
        $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
    }); 
		</script>   
		<script>
			$(function () {
				 $(document).delegate("#intercheckedAll","change", function() {
        if (this.checked) {
            $(".internationaldata .checkSingle").each(function() {
                this.checked=true;
            });
			//$(".displayifselected").show();
        } else {
            $(".internationaldata  .checkSingle").each(function() {
                this.checked=false;
            });
			//$(".displayifselected").hide();
        }
    });
				  $(document).delegate("#domrcheckedAll","change", function() {
        if (this.checked) {
            $(".domesticdata .checkSingle").each(function() {
                this.checked=true;
            });
			//$(".displayifselected").show();
        } else {
            $(".domesticdata  .checkSingle").each(function() {
                this.checked=false;
            });
			//$(".displayifselected").hide();
        }
    });
				 $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
			$(".displayifselected").show();
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
			$(".displayifselected").hide();
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
			
            var isAllChecked = 0;
            var atleast1Checked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });
			
            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            } 
			  
        }
        else {
            $("#checkedAll").prop("checked", false);
			
        }
		
		var count_checked = $("[name='allcheckbox']:checked").length;		
			  if(count_checked == 0) 
				{
					$(".displayifselected").hide();
				}else{
					$(".displayifselected").show();
				}
    });
	
				//Enable check and uncheck all functionality
				$('.checkbox-toggle').click(function () {
				  var clicks = $(this).data('clicks')
				  if (clicks) {
					//Uncheck all checkboxes
					$('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
					$('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square');
					$(".is_selected_invoice").hide();
					$(".is_not_selected_invoice").css("visibility","visible");
				  } else {
					//Check all checkboxes
					$('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
					$('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square');
					$(".is_selected_invoice").show();
					$(".is_not_selected_invoice").css("visibility","hidden");
				
					var v = $('input[name="invoicelist[]"]:checked').length;
					$(".selected_no").html(v);
				  }
				  $(this).data('clicks', !clicks)
				});
				
				$(".seleccheckbox").click(function () {
        if ($(this).is(":checked")) {
			
            var isAllChecked = 0;
            var atleast1Checked = 0;

            $(".seleccheckbox").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });
		}
        else {
            
        }
		
		var v = $('input[name="invoicelist[]"]:checked').length;
					$(".selected_no").html(v);	
			  if(v == 0) 
				{
					$(".is_selected_invoice").hide();
					$(".is_not_selected_invoice").css("visibility","visible");
				}else{
					$(".is_selected_invoice").show();
					$(".is_not_selected_invoice").css("visibility","hidden");
				}
    });

				//Handle starring for glyphicon and font awesome
				$('.mailbox-star').click(function (e) {
				  e.preventDefault()
				  //detect type
				  var $this = $(this).find('a > i')
				  var glyph = $this.hasClass('glyphicon')
				  var fa    = $this.hasClass('fa')

				  //Switch states
				  if (glyph) {
					$this.toggleClass('glyphicon-star')
					$this.toggleClass('glyphicon-star-empty')
				  }

				  if (fa) {
					$this.toggleClass('fa-star')
					$this.toggleClass('fa-star-o')
				  }
				})
			  })
		</script>
		<script>
			$(function () {
				var oTable = $('#citytable').DataTable({
						processing: true,
						serverSide: true,
						stateSave: true,
						searching: false,
						/*		
						 "order": [[1, "asc"]],            
						 paging: true,
						 info: true,
						 */
						ajax: {
							url: '{!! route('fetch.data.cities') !!}',
			   
						}, columns: [
							{data: 'id', name: 'id'},
							{data: 'name', name: 'name'},
							{data: 'action', name: 'action', orderable: false, searchable: false}
						]
					});
			});
		</script>									
		<script>
			$('.cus_session_1').on('click', function(){
				$('#activesession_info6').modal('show');
			});	
			$('.cus_session_2').on('click', function(){
				$('#activesession_info1').modal('show');
			});	
			$('.cus_session_3').on('click', function(){
				$('#activesession_info2').modal('show'); 
			});	
			$('.view_btn a').on('click', function(){
				$('.view_all').show();
				$(this).parent('div').hide();
			});
		</script>									
	</body>
</html> 