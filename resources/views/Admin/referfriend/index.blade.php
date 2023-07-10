@extends('layouts.admin')
@section('title', 'Refer A Friend')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Refer A Friend</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Refer A Friend</li>
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
			<div class="card referal_card">
				<div class="row">
					<div class="col-md-9">
						<div class="card-header">  
							<div class="card-title">Love using <span style="color:#000;">Book Matic CRM</span>? Tell it to your friends!</div> 
						</div>
						<div class="card-body"> 
							<div class="referral-social">
								<!-- Go to www.addthis.com/dashboard to customize your tools -->
								<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e958b2bccacaa35"></script>
								<div class="addthis_inline_share_toolbox"></div>
								
								<!--<a class="btn btn-social" href="#" target="_blank" rel="noreferrer noopener"><i class="fa fa-facebook-square fb_icon"></i> Facebook </a>
								<a class="btn btn-social" href="#" target="_blank" rel="noreferrer noopener"><i class="fa fa-twitter-square tw_icon"></i> Twitter </a>
								<a class="btn btn-social" href="#" target="_blank" rel="noreferrer noopener"><i class="fa fa-google-plus-square gplus_icon"></i> Google+ </a>-->
								
								<div class="or-divider text-muted text-center">
									<span>or</span>
								</div> 
							</div>
							<div class="referral-form">
								<!--<button type="button" class="btn btn-secondary btn-block" data-container="body" data-role="popover" data-placement="bottom"  data-html="true" data-content='<div id="popover-content" style="max-width:700px">

						    <div class="row">
						    <div class="col-md-12 no-padding">
							    <div class="box-header with-border no-padding">
								    <div class="form-group row" style="margin-bottom:12px" >
										<label for="inputEmail3" class="col-sm-3 control-label c6 no-padding f13" style="margin-top:8px">Add Note</label>
										<div class="col-sm-9 no-padding">
										    <input id="remindernote" class="form-control f13" placeholder="Enter an optional note...." type="text">
										</div>
										<div class="clearfix"></div>
								    </div>

							    </div>
							    <div class="box-body" style="padding-bottom:0">
								    <div class="c6 f13 text-bold">Set Date & Time</div>
									<div class="row">
										<div class="col-md-5 form-group no-padding mt2 f13" id="timegroup" style="line-height:28px">
											<label class="c6 f12">Presets</label><br/>
											<a href="#" title="" onmouseover="setTitledate(this)" onClick="setDateTimeInput(this); return false;" id="hrs2" data-toggle="tooltip">In 2 hours</a><br/>
											<a href="#" title="" onmouseover="setTitledate(this)" onClick="setDateTimeInput(this);  return false;" id="hrs4"  data-toggle="tooltip">In 4 hours</a><br/>
											<a href="#" title="" onmouseover="setTitledate(this)" onClick="setDateTimeInput(this);  return false;" id="tom_mor" data-toggle="tooltip">Tomorrow morning</a><br/>
											<a href="#" title="" onmouseover="setTitledate(this)" onClick="setDateTimeInput(this);  return false;" id="tom_eve" data-toggle="tooltip">Tomorrow evening</a><br/>
											<a href="#" title="" onmouseover="setTitledate(this)" onClick="setDateTimeInput(this);  return false;" id="tow_day" data-toggle="tooltip">In 2 Days</a><br/>
											<a href="#" title="" onmouseover="setTitledate(this)" onClick="setDateTimeInput(this);  return false;" id="in_week"  data-toggle="tooltip">In 1 Week</a><br/>
										</div>
										<div class="col-md-6 form-group no-padding no-margin">
											<div class="">
												<div id="embeddingDatePicker" class="f13"></div>
											</div>
										</div>
									</div>
							    </div>
							    <div class="box-footer row" style="padding:10px 0">
									<div class="col-md-12 no-padding">
										<div class="row">
											<div class="col-xs-4 form-group no-padding">
												<select class="form-control selec_reg" id="rem_cat" name="rem_cat" onchange="">
													<option value="1" >Regardless</option>
													<option value="2">If no reply</option>
												</select>
											</div>
											<div class="col-xs-5 form-group">
												<div class="input-group date" >
												<input type="text" class="form-control f13" placeholder="dd/mm/yyyy"  onkeyup="changDatepickerDate(this)" id="popoverdate" name="popoverdate">
												</div>
											</div>
											<div class="col-xs-3 form-group no-padding">
												<div class="input-group time">
												<input type="text" class="form-control f13" placeholder="hh:mm am" onkeyup="changDatepickerDate(this)"  id="popovertime" name="popovertime">
												</div>
											</div>
										</div>
										<input type="hidden" value="" id="popoverrealdate" name="popoverrealdate" />
									</div>
								</div>

							    <div class="col-md-12 no-padding text-center">
									<button  class="btn btn-danger" id="setreminder">Set Reminder</button>
							    </div>

							    </div>

						    </div>   
 
					    </div>'> Reminder</button>  -->   
						
						
								<form action="">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label style="color:#ff0000;">Email *</label>
												<input type="email" name="email" class="form-control" placeholder="Your friend's business email" />
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label style="color:#ff0000;">Subject *</label>
												<input type="text" name="subject" class="form-control" placeholder="Check Out Book Matic CRM!" />
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label style="color:#ff0000;">Message *</label>
												<textarea name="message" class="form-control" style="height:150px;">Your friend's Messages</textarea> 
											</div> 
											<div class="form-group">
												<input type="submit" class="btn btn-lg btn-primary" value="Invite Your Friend"/> 
											</div> 
										</div> 
									</div> 
								</form>
							</div>	
						</div>	
					</div>	 
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection