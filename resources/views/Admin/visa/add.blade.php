@extends('layouts.admin')
@section('title', 'Staff')
<Style>
   .errorRe{
   color:red;
   }
   img{
   max-height:60px;
   }
</Style>
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">{{ isset($visa) ? "Edit" : 'Add' }} Visa</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Visa</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <section class="content">
      	<div class="container-fluid">
			<div class="row">
				{!! Session::has('msg') ? Session::get("msg") : '' !!}
				<div class="col-md-12">
					<!-- Flash Message Start -->
					<div class="server-error">
					    <!--@if (count($errors) > 0)-->
         <!--                   <div class="alert alert-danger">-->
         <!--                       <ul>-->
         <!--                           @foreach ($errors->all() as $error)-->
         <!--                               <li>{{ $error }}</li>-->
         <!--                           @endforeach-->
         <!--                       </ul>-->
         <!--                   </div>-->
         <!--               @endif-->
						@include('../Elements/flash-message')
					</div>
					<!-- Flash Message End -->
					<!-- form start -->
					{{ Form::open(array('url' => 'admin/visa/save', 'name'=>"add-staff", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "method"=>"post")) }}
					@csrf
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Add Basic Details</h3>
						</div>

						<input type="hidden" name="id" class="form-control" value="{{ isset($visa) ? $visa->id : '' }}" value="" autocomplete="off">

						<div class="card-body">
							<div class="row visaAddform">
								<div class="col-md-12">
									<div class="form-group">
									<label for="first_name">Visa Category <span class="errorRe">*</span></label>
									<select class="form-control select2" name="visa_category" id="visa_category">
									    <option selected disabled>Select Visa Category</option>
									    @foreach($categories as $category)
										<option value="{{ $category->id }}" {{ isset($visa) && $visa->visa_category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
										@endforeach
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="first_name">Country From <span class="errorRe">*</span></label>
									<select class="form-control select2" name="country_from" id="country_from">
									    <option selected disabled>Select Country</option>
									    @foreach($country as $count)
										<option value="{{ $count->id }}" {{ isset($visa) && $visa->country_from == $count->id ? 'selected' : '' }}>({{ $count->sortname }}) {{ $count->name }}</option>
										@endforeach
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="first_name">Country To <span class="errorRe">*</span></label>
									<select class="form-control select2" name="country_to" id="country_to">
										<option selected disabled>Select Country</option>
									    @foreach($country as $count)
										<option value="{{ $count->id }}" {{ isset($visa) && $visa->country_to == $count->id ? 'selected' : '' }}>({{ $count->sortname }}) {{ $count->name }}</option>
										@endforeach
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="first_name">Traveler City <span class="errorRe">*</span></label>
									<select class="form-control select2" name="traveler_city" id="traveler_city">
									<option selected disabled>Select City</option>
									    @foreach($cities as $city)
										<option value="{{ $city->id }}" {{ isset($visa) && $visa->traveler_city == $city->id ? 'selected' : '' }} >{{ $city->name }}</option>
										@endforeach
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="first_name">Visa Proccessing <span class="errorRe">*</span></label>
									<select class="form-control select2" name="visa_processing" id="visa_processing">
										<option value="Express" {{ isset($visa) && $visa->visa_processing == 'Express' ? 'selected' : '' }} >Express</option>
										<option value="Normal" {{ isset($visa) && $visa->visa_processing == 'Normal' ? 'selected' : '' }} >Normal</option>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="first_name">Visa Title <span class="errorRe">*</span></label>
									<input type="text" name="visa_title" class="form-control" value="{{ isset($visa) ? $visa->visa_title : '' }}" required
										value="" autocomplete="off">
									</div>
									@php
									$resulti = isset($visa) ? $visa->banner_img : '';
									@endphp
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="first_name">Banner Image</label>
									<input type="file" name="banner_img" class="form-control" autocomplete="off">
									<div class="cardImg">
										<img src="{{ !empty($resulti) ? URL::to('/public/img/visaBanner/'). '/'  . $resulti : "" }}" alt="{{ $resulti }}">
									</div>
									</div>
								</div>
								<hr>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Description Title</label>
									<input type="text" name="descritionTitle" class="form-control"
										value="{{ isset($visa) ? $visa->descritionTitle : '' }}" placeholder="Description" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Description Details</label>
									<textarea name="descrptionDetails" data-valid="" class="textarea"
										placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->descrptionDetails : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Clients Documents Title</label>
									<input type="text" name="clientsDocTitle" class="form-control"
										value="{{ isset($visa) ? $visa->clientsDocTitle : '' }}" placeholder="Clients Documents" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Clients Documents Details</label>
									<textarea name="clientDoc_details" data-valid="" class="textarea"
										placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->clientDoc_details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Holiday Planner Assistance Title</label>
									<input type="text" id="holida_assis_title" name="holida_assis_title"
										value=" {{ isset($visa) ? $visa->holida_assis_title : '' }}" placeholder="Holiday Planner Assistance" class="form-control" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Holiday Planner Assistance Details</label>
									<textarea name="holiday_planer_Assest_details" data-valid="" class="textarea"
										placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->holiday_planer_Assest_details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Special Note Title</label>
									<input type="text" name="special_note_title" class="form-control"
										value="{{ isset($visa) ? $visa->special_note_title : '' }}" placeholder="Special Note" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Special Note Details</label>
									<textarea name="special_note_details" data-valid="" class="textarea" placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->special_note_details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">How to apply Title</label>
									<input type="text" name="how_to_ApplyTitle" class="form-control" value="{{ isset($visa) ? $visa->how_to_ApplyTitle : '' }}" placeholder="How to apply" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">How to apply Details</label>
									<textarea name="how_to_apply_details" data-valid="" class="textarea"
										placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->how_to_apply_details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Visa Info Title</label>
									<input type="text" name="visa_info_title" class="form-control" value=" {{ isset($visa) ? $visa->visa_info_title : '' }}" placeholder="Visa Info Title"
										autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Visa Info Details</label>
									<textarea name="visa_info_details" data-valid="" class="textarea" placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->visa_info_details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Terms & Conditions Title</label>
									<input type="text" name="terms_condition_title" class="form-control"
										value="{{ isset($visa) ? $visa->terms_condition_title : '' }}" placeholder="Terms & Conditions" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Terms & Conditions Details</label>
									<textarea name="term_condition_Details" data-valid="" class="textarea"
										placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->term_condition_Details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="first_name">Holiday List Title</label>
									<input type="text" name="holiday_list_title" class="form-control" value="{{ isset($visa) ? $visa->holiday_list_title : '' }}" placeholder="Holiday List" autocomplete="off">
									</div>
									<div class="form-group">
									<label for="first_name">Holiday List Details</label>
									<textarea name="holiday_list_details" data-valid="" class="textarea"
										placeholder="Please Add Description Here"
										style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ isset($visa) ? $visa->holiday_list_details : '' }}</textarea>
									@if ($errors->has('first_name'))
									<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('first_name') }}</strong>
									</span>
									@endif
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Add Price</h3>
						</div>
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-md-12">
									<div class="form-group">
									<label for="first_name" class="d-block">Visa Type <span class="errorRe">*</span></label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="visa_type" id="inlineRadio1" value="tourist" {{ isset($visa) && $visa->visa_type == 'tourist' ? 'checked' : '' }}>
										<label class="form-check-label" for="inlineRadio1">Tourist Visa</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="visa_type" id="inlineRadio2" value="business" {{ isset($visa) && $visa->visa_type == 'business' ? 'checked' : '' }} >
										<label class="form-check-label" for="inlineRadio2">Business Visa</label>
									</div>
									</div>
								</div>

								<div class="col-md-3">
									<label for="first_name" class="d-block"><strong>Adult Price</strong></label>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="">B2C</label>
										<input type="number" name="adult_b2c_price" class="form-control" value="{{ isset($visa) ? $visa->adult_b2c_price : '' }}">
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="">B2B</label>
										<input type="number" name="adult_b2b_price" class="form-control" value="{{ isset($visa) ? $visa->adult_b2b_price : '' }}" >
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="">Corporate</label>
										<input type="number" name="adult_corporate_price" class="form-control" value="{{ isset($visa) ? $visa->adult_corporate_price : '' }}">
									</div>
								</div>
							</div>

							<div class="row align-items-center">
								<div class="col-md-3">
									<label for="first_name"  class="d-block"><strong>Child Price</strong></label>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="">B2C</label>
										<input type="number" name="child_b2c_price" class="form-control" value="{{ isset($visa) ? $visa->child_b2c_price : '' }}" >
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="">B2B</label>
										<input type="number" name="child_b2b_price" class="form-control" value="{{ isset($visa) ? $visa->child_b2b_price : '' }}" >
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="">Corporate</label>
										<input type="number" name="child_corporate_price" class="form-control" value="{{ isset($visa) ? $visa->child_corporate_price : '' }}" >
									</div>
								</div>

							</div>
						</div>
					</div>


					{{ Form::submit('Save', ['class'=>'btn btn-primary' ]) }}
					{{ Form::close() }}

					<!-- form end -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Pricing Details</h3>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover text-nowrap">
									<thead>
										<tr>
											<th>Visa Category</th>
											<th>Visa Type</th>
											<th>Processing Type</th>
											<th>Adult B2B</th>
											<th>Adult B2C</th>
											<th>Adult Corporate</th>
											<th>Child B2B</th>
											<th>Child B2C</th>
											<th>Child Corporate</th>
										</tr>
									</thead>
									
									<tbody>
										<tr>
											<td>10 Days Visa</td>
											<td>{{ isset($visa) ? ucfirst($visa->visa_type) : '' }} Visa</td>
											<td>{{ isset($visa) ? $visa->visa_processing : '' }}</td>
											<td>{{ isset($visa) ? $visa->adult_b2b_price : '' }}</td>
											<td>{{ isset($visa) ? $visa->adult_b2c_price : '' }}</td>
											<td>{{ isset($visa) ? $visa->adult_corporate_price : '' }}</td>
											<td>{{ isset($visa) ? $visa->child_b2b_price : '' }}</td>
											<td>{{ isset($visa) ? $visa->child_b2c_price : '' }}</td>
											<td>{{ isset($visa) ? $visa->adult_corporate_price : '' }}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end tab content -->
		</div>
   </section>
</div>

@endsection