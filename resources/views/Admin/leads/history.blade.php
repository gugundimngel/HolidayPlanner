@extends('layouts.admin')
@section('title', 'Leads')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Leads</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Leads</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->	
	<!-- Breadcrumb start-->
	<!--<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			Home / <b>Dashboard</b>
		</li>
		@include('../Elements/Admin/breadcrumb')
	</ol>-->
	<!-- Breadcrumb end-->
	
	<!-- Main content --> 
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Flash Message Start -->
					<div class="server-error">
						@include('../Elements/flash-message')
					</div>
					<!-- Flash Message End -->
				</div>									
			</div>
			<div class="row">
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="card card-danger card-outline">
						<div class="card-body box-profile">
							<div class="text-center">
								<img class="profile-user-img img-fluid img-circle" src="{{URL::to('/public/img/profile_imgs')}}/beach-umbrella_1cBKnHFSOq.png" class="img-circle elevation-2"/>
							</div>
							<h3 class="profile-username text-center">{{(@$fetchedData->name)}}</h3>
							<p class="text-muted text-center"><i class="fa fa-phone"></i>  {{(@$fetchedData->phone)}}</p>
							
							<ul class="list-group list-group-unbordered mb-3">
							  <li class="list-group-item">
								<b>Mail From:</b> 
								<div class="float-right mail_icon">
									<ul>
										<li><a href="#"><i class="fa fa-google"></i></a></li>
										<li><a href="#"><i class="fa fa-yahoo"></i></a></li>
									</ul>
								</div>
							  </li>
							  <li class="list-group-item">
								<b>Assigned</b> 
								<div class="float-right lead_assigned">
									<span>{{@$fetchedData->staffuser->first_name}} {{@$fetchedData->staffuser->last_name}}</span>
								</div>
							  </li>
							</ul>
						</div>
					  <!-- /.card-body -->
					</div>
					<!-- /.card -->

					<!-- About Me Box -->
					<div class="card card-danger card-outline">
						<div class="card-header p-2">
							<h5 class="">Lead Details</h5>
						</div>
					  <!-- /.card-header -->
						<div class="card-body p-2">							
							<strong><i class="fas fa-book mr-1"></i> Going To</strong>
							<p class="text-muted">{{@$fetchedData->going_to}}</p>
							<hr>
							<div class="departure_txt cus_lead_txt">	
								<strong>Departure:</strong>							
								<span class="departure_value">05/04/2020</span>
							</div>
							<hr>
							<div class="duration_txt cus_lead_txt">	
								<strong>Duration:</strong>							
								<span class="duration_value">{{@$fetchedData->duration_night}} Nights / {{@$fetchedData->duration_day}} Days</span>
							</div>
							<hr>
							<div class="budget_txt cus_lead_txt">	
								<strong>Budget:</strong>							
								<span class="duration_value">Standard (3 - 4 Stars)</span>
							</div>
							<hr>
							<strong><i class="fas fa-car mr-1"></i> People Travelling</strong>
							<div class="people_travel">
								<div class="adult_value inner_value">
									<i class="fas fa-male"></i><input value="{{@$fetchedData->adults}}" class="form-control" type="text" placeholder="2"/>
								</div>
								<div class="child_value inner_value">
									<i class="fas fa-child"></i><input value="{{@$fetchedData->children}}" class="form-control" type="text" placeholder="0"/>
								</div> 
								<div class="baby_value inner_value">
									<i class="fas fa-baby"></i><input value="{{@$fetchedData->baby}}" class="form-control" type="text" placeholder="0"/>
								</div>  
								<div class="clearfix"></div>
							</div> 
							<hr>
							<strong><i class="fas fa-file mr-1"></i> Requirement</strong>
							<div class="require_textarea">
								<textarea class="form-control" placeholder="I am looking for a trip. approx. INR 79998">{{@$fetchedData->customize_package}}</textarea>
							</div>
							<br>							
						</div>
					  <!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
				<div class="col-md-9"> 
					<div class="card card-danger card-outline">
						<div class="card-header p-2">
							<h5 class="">Followup History</h5>
						</div><!-- /.card-header -->						
						<div class="card-body">
							<div class="followup_btn"> 
								<ul class="navbar-nav">
									<li class="nav-item d-sm-inline-block update_stage">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
										  Update Status <span class="caret"></span>
										</a>
										<div class="dropdown-menu" x-placement="top-start">
											<a class="dropdown-item opennotepopup" data-notename="Creating Porposal" data-notetype="creating_porposal" tabindex="-1" href="javascript:;">Creating Porposal</a>
											
											<a class="dropdown-item opennotepopup" data-notename="Undecided" data-notetype="undecided" tabindex="-1" href="javascript:;">Undecided</a>
											<a class="dropdown-item opennotepopup" data-notename="Lost" data-notetype="lost" tabindex="-1" href="javascript:;">Lost</a>
											<a class="dropdown-item opennotepopup" data-notename="Won" data-notetype="won" tabindex="-1" href="javascript:;">Won</a>
											<a class="dropdown-item opennotepopup" data-notename="Ready to pay" data-notetype="ready_to_pay" tabindex="-1" href="javascript:;">Ready to pay</a>
											<a class="dropdown-item opennotepopup" data-notename="Interested" data-notetype="interested" tabindex="-1" href="javascript:;">Interested</a>
											<a class="dropdown-item opennotepopup" data-notename="Quote Sent" data-notetype="quote_sent" tabindex="-1" href="javascript:;">Quote Sent</a>
											<a class="dropdown-item opennotepopup" data-notename="Call Letter" data-notetype="call_letter" tabindex="-1" href="javascript:;">Call Letter</a>
											<a class="dropdown-item opennotepopup" data-notename="Wrong Number" data-notetype="wrong_number" tabindex="-1" href="javascript:;">Wrong Number</a>
											<a class="dropdown-item opennotepopup" data-notename="Trip Cancelled" data-notetype="trip_cancelled" tabindex="-1" href="javascript:;">Trip Cancelled</a>
											<a class="dropdown-item opennotepopup" data-notename="Payment Followup" data-notetype="payment_followup" tabindex="-1" href="javascript:;">Payment Followup</a>
											<a class="dropdown-item opennotepopup" data-notename="Advance Received" data-notetype="advance_received" tabindex="-1" href="javascript:;">Advance Received</a>
											<a class="dropdown-item opennotepopup" data-notename="Balance Received" data-notetype="balance_received" tabindex="-1" href="javascript:;">Balance Received</a>
										</div>
									</li> 
									<li class="nav-item d-sm-inline-block add_note">
										<button type="button" class="btn btn-secondary btn-block" data-container="body" data-role="popover" data-placement="bottom" data-html="true" data-content="<div id=&quot;popover-content&quot;>
							    <div class=&quot;box-header with-border&quot;>
								    <div class=&quot;form-group row&quot; style=&quot;margin-bottom:12px&quot; >
										<label for=&quot;inputEmail3&quot; class=&quot;col-sm-3 control-label c6 f13&quot; style=&quot;margin-top:8px&quot;>Add Note</label>
										<div class=&quot;col-sm-9&quot;>
										    <input id=&quot;remindernote&quot; class=&quot;form-control f13&quot; placeholder=&quot;Enter an optional note....&quot; type=&quot;text&quot;>
										</div>
										<div class=&quot;clearfix&quot;></div>
								    </div>

							    </div> 
							    <div class=&quot;box-body&quot; style=&quot;padding-bottom:0&quot;>
								    <div class=&quot;c6 f13 text-bold&quot;>Set Date &amp; Time</div>
									<div class=&quot;row&quot;>
										<div class=&quot;col-sm-5 form-group mt2 f13&quot; id=&quot;timegroup&quot; style=&quot;line-height:28px&quot;>
											<label class=&quot;c6 f12&quot;>Presets</label><br/>
											<a href=&quot;#&quot; title=&quot;&quot; onmouseover=&quot;setTitledate(this)&quot; onClick=&quot;setDateTimeInput(this); return false;&quot; id=&quot;hrs2&quot; data-toggle=&quot;tooltip&quot;>In 2 hours</a><br/>
											<a href=&quot;#&quot; title=&quot;&quot; onmouseover=&quot;setTitledate(this)&quot; onClick=&quot;setDateTimeInput(this);  return false;&quot; id=&quot;hrs4&quot;  data-toggle=&quot;tooltip&quot;>In 4 hours</a><br/>
											<a href=&quot;#&quot; title=&quot;&quot; onmouseover=&quot;setTitledate(this)&quot; onClick=&quot;setDateTimeInput(this);  return false;&quot; id=&quot;tom_mor&quot; data-toggle=&quot;tooltip&quot;>Tomorrow morning</a><br/>
											<a href=&quot;#&quot; title=&quot;&quot; onmouseover=&quot;setTitledate(this)&quot; onClick=&quot;setDateTimeInput(this);  return false;&quot; id=&quot;tom_eve&quot; data-toggle=&quot;tooltip&quot;>Tomorrow evening</a><br/>
											<a href=&quot;#&quot; title=&quot;&quot; onmouseover=&quot;setTitledate(this)&quot; onClick=&quot;setDateTimeInput(this);  return false;&quot; id=&quot;tow_day&quot; data-toggle=&quot;tooltip&quot;>In 2 Days</a><br/>
											<a href=&quot;#&quot; title=&quot;&quot; onmouseover=&quot;setTitledate(this)&quot; onClick=&quot;setDateTimeInput(this);  return false;&quot; id=&quot;in_week&quot;  data-toggle=&quot;tooltip&quot;>In 1 Week</a><br/>
										</div>
										<div class=&quot;col-sm-1 no-margin&quot;></div>
										<div class=&quot;col-sm-6 form-group no-margin&quot;>
											<div class=&quot;&quot;>
												<div id=&quot;embeddingDatePicker&quot; class=&quot;f13&quot;></div>
											</div>
										</div>
								    </div>
							    </div>
							    <div class=&quot;box-footer&quot; style=&quot;padding:10px 0&quot;>
							    <div class=&quot;row&quot;>
							    <div class=&quot;col-sm-4 form-group&quot;>
							    <select class=&quot;form-control selec_reg&quot; id=&quot;rem_cat&quot; name=&quot;rem_cat&quot; onchange=&quot;&quot;>
								    <option value=&quot;1&quot; >Regardless</option>
								    <option value=&quot;2&quot;>If no reply</option>
							    </select>

							    </div> 

							    <div class=&quot;col-sm-5 form-group&quot;>
								    <div class=&quot;input-group date&quot; >
									<input type=&quot;text&quot; class=&quot;form-control f13&quot; placeholder=&quot;yyyy-mm-dd&quot;  onkeyup=&quot;changDatepickerDate(this)&quot; id=&quot;popoverdate&quot; name=&quot;popoverdate&quot;>
								    </div>
							    </div>
							    <div class=&quot;col-sm-3 form-group&quot;>
								    <div class=&quot;input-group time&quot;>
									<input type=&quot;text&quot; class=&quot;form-control f13&quot; placeholder=&quot;hh:mm am&quot; onkeyup=&quot;changDatepickerDate(this)&quot;  id=&quot;popovertime&quot; name=&quot;popovertime&quot;>
									<input id=&quot;leadid&quot;  type=&quot;hidden&quot; value=&quot;{{base64_encode(convert_uuencode(@$fetchedData->id))}}&quot;>
								    </div>
							    </div>
<input type=&quot;hidden&quot; value=&quot;&quot; id=&quot;popoverrealdate&quot; name=&quot;popoverrealdate&quot; />
							    </div>

							    <div class=&quot;row text-center&quot;>
									<div class=&quot;col-md-12 text-center&quot;>
									<button  class=&quot;btn btn-danger&quot; id=&quot;setreminder&quot;>Set Reminder</button>
									</div>

							    </div>


					    </div>" data-original-title="" title=""> Followup</button>
										
									</li>
									<li class="nav-item d-sm-inline-block mail_compose">
										<a class="nav-link" href="#"><i class="fas fa-envelope"></i> Mail Compose</a>  
									</li>  
								</ul> 
							</div>
							<div class="history_timeline">
								<ul class="nav nav-pills">
									<li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">History</a></li> 
								</ul>
								<div class="tab-content">								
									<!-- /.tab-pane -->
									<div class="active tab-pane" id="timeline">
										<!-- The timeline -->
										<div class="timeline timeline-inverse followuphistory">
											<!-- END timeline item -->
											<div>
												<i class="far fa-clock bg-gray"></i>
											</div>
										</div>
									</div>
								</div>
								<!-- /.tab-content -->
							</div>
						</div><!-- /.card-body -->
					</div>
					<!-- /.nav-tabs-custom -->
				</div>
				<!-- /.col -->
			</div>
		</div>
	</section>
</div>

<div id="myAddnotes" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"> 
			<h4 class="modal-title">Modal Header</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				
			</div>
			{{ Form::open(array('url' => 'admin/followup/store', 'name'=>"add-note", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", 'id'=>"addnoteform")) }}
			<div class="modal-body">
				<div class="customerror"></div> 
				<div class="form-group row">
					<div class="col-sm-12">
						<input id="note_type" name="note_type" type="hidden" value="">
						<input id="" name="lead_id" type="hidden" value="{{base64_encode(convert_uuencode(@$fetchedData->id))}}">
						<textarea id="description" name="description" class="form-control" placeholder="Add note" style=""></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-note")' ]) }}
			</div>
			 {{ Form::close() }}
		</div>
	</div>
</div>
<script> 

var lead_id = '{{base64_encode(convert_uuencode(@$fetchedData->id))}}';
jQuery(document).ready(function($){
	setInterval(function(){
           myfollowuplist(lead_id);
            },
            1*60*1000);
	myfollowuplist(lead_id);

});
</script>
@endsection