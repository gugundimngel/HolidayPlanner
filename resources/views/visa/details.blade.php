
@extends('layouts.frontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', @$seoDetails->meta_title)
@section('meta_keyword', @$seoDetails->meta_keyword)
@section('meta_description', @$seoDetails->meta_desc)
@section('bodyclass', 'homepage')
@section('pagespecificstyles')

@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css ">
    
    
     <style>
        body {
            background-color: whitesmoke;
        }

        .visaDetailsBanner {
            position: relative;
            min-height: 350px;
            margin-bottom: 40px;
            background: #135ea0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /*.bannerContent {*/
        /*    position: absolute;*/
        /*    bottom: -50px;*/
        /*    width: 100%;*/
        /*}*/

        .bannerContent .card {
            padding: 10px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row;
            border: 0;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
            background: #fff;
            border-radius: 4px;
        }

        .visaDetailsBanner h1 {
            font-size: 25px;
            margin-bottom: 0;
            margin-bottom: 8px;
        }

        .visaDetailsBanner h2 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .visaDetailsBanner h2 span {
            font-size: 20px;
            margin-left: 4px;
        }

        .visaBook {
            padding: 12px 40px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            background-color: #f86638;
            color: #fff;
            display: block;
            width: fit-content;
            border-radius: 3px;
            border: 0;
            margin-left: auto;
        }

        .starRatings i {
            font-size: 12px;
            color: #f86638;
        }


        .reviewCount {
            margin-left: 5px;
            color: #9f9f9f;
        }


        .visa_Details_Section .card {
            border: 0;
            padding: 20px 15px;
            border-radius: 6px;
            margin-bottom: 30px;
            background: #fff;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
        }
        
        #full-container {
            background-color: #f3f3f3;
        }

        .hightlights {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .hightlights span i {
            margin-right: 5px;
        }

        .control-label {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-control {
            height: 36px;
            font-size: 14px;
            font-weight: 600;
        }

        .visa_Details_Section .card_title {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .price {
            background-color: whitesmoke;
            padding: 10px;
            max-width: 200px;
            border-radius: 5px;
            text-align: center;
            margin: 0 auto;
        }

        .price p {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .price span {
            font-weight: 600;
            color: #f86638;
            font-size: 18px;
        }

        .formActions {
            text-align: right;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid whitesmoke;
        }

        .formActions button {
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 3px;
            border: 1px solid #f86638;
        }

        .btnOutline {
            background: transparent;
            color: #f86638;
            margin-right: 15px;
        }

        .btnFilled {
            background: #f86638;
            color: #fff;
        }

        .visa_Details_Section ul li {
            line-height: 30px;
        }

        .acc {
            margin-bottom: 10px;
        }

        .acc-head {
            background-color: #f3f3f3;
            padding: 10px 30px;
            font-size: 16px;
            position: relative;
            cursor: pointer;
            border-radius: 50px;
        }

        .acc-head::before,
        .acc-head::after {
            content: '';
            position: absolute;
            top: 50%;
            background-color: #121212;
            transition: all .3s;
        }

        .acc-head::before {
            right: 39px;
            width: 3px;
            height: 13px;
            margin-top: -7px;
        }

        .acc-head::after {
            right: 34px;
            width: 13px;
            height: 3px;
            margin-top: -2px;
        }

        .acc-head p {
            color: #121212;
            margin-bottom: 0;
        }

        .acc-content {
            padding: 15px 10px;
            display: none;
        }

        .acc-head.active::before {
            transform: rotate(90deg);
        }
        
        .visa_Details_Section h6 {
            font-size: 14px;
            font-weight: 500;
        }
        
        .visa_Details_Section ul {
            padding-left: 30px;
        }
        
        .visa_Details_Section ul li {
            list-style: disc;
        }
        
        table thead th {
            border-bottom: 0 !important;
        }
        
        .form-group{
            margin-bottom: 20px !important;
        }
        
        .testimonialsSect .testimonial-item.equal-height.style-6 {
            background-color: #fff;
            border-radius: 10px;
            margin: 10px;
            padding: 20px;
            box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
        }
        
        .testimonialsSect .cell-right {
            padding-bottom: 20px;
        }
        
        .testimonialsSect .testimonial-name {
            font-weight: 600;
            color: #222;
        }
        
        
        .testimonialsSect i.fa.fa-quote-left {
            padding: 0px 10px;
            color: #999;
        }
        
        .testimonialsSect .owl-dot {
            height: 10px;
            width: 10px;
            border: 1px solid #c3c3c3;
            border-radius: 100%;
            background: #ffffff4a;
        }
        
        .testimonialsSect .owl-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .testimonialsSect .owl-dot.active {
            background: #f86638;
            border-color: #f86638;
        }
        
        .relatedRooms {
            padding: 50px 0;
            background: #ffffff;
            margin-top: 20px;
        }
        
        .relatedRooms h2 {
            margin-bottom: 20px;
        }
        
        .testimonialsSect .owl-nav {
            display: none;
        }
        
        .testimonialsSect .card_title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .reviewsCount {
            background: #f86638;
            padding: 2px 14px;
            border-radius: 50px;
            color: #fff;
            font-size: 14px;
        }
        
        .reviewsCount i {
            font-size: 12px;
            position: relative;
            top: -1px;
        }
        
        @media(max-width: 991px){
            .bannerContent .card {
                flex-wrap: wrap;
                gap: 20px;
                padding: 26px;
            }
            
            .visaBook {
                margin: 15px 0 0;
            }
            
            .visaDetailsBanner {
                padding: 100px 0 80px;
            }
        }
        
        @media(max-width: 768px){
            .hightlights {
                flex-wrap: wrap;
               gap: 10px;
            }
            
            .hightlights>span {
                flex: 0 0 100%;
                text-align: center;
            }
            
            .bannerContent .card {
                justify-content: center;
            }
        }
    </style>


</head>

<body>

    <div class="visaDetailsBanner">
        <div class="bannerContent">
            <div class="container">
                <div class="card">
                    <div>
                        <h1>{{$visa->visa_title ?? ''}}</h1>
                        <!--<span class="starRatings">-->
                        <!--    <i class="fas fa-star"></i>-->
                        <!--    <i class="fas fa-star"></i>-->
                        <!--    <i class="fas fa-star"></i>-->
                        <!--    <i class="fas fa-star"></i>-->
                        <!--    <i class="far fa-star"></i>-->
                        <!--</span>-->
                        <!--<span class="reviewCount">61 Reviews</span>-->
                    </div>

                    <div class="hightlights">
                        <span><i class="far fa-calendar-alt"></i> Normal 3-4 Working Days</span>
                        <span><i class="far fa-file-alt"></i> Easy Documentation</span>
                        <span><i class="fas fa-credit-card"></i> Online Payment Option</span>
                    </div>

                    <div>
                        <h2>from <span>IND {{ $visa->priceb2c }}</span></h2>
                        <button class="visaBook">Book Now</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container visa_Details_Section">
        <div class="card pricingForm">
            <h4 class="card_title">Visa Prices & Options</h4>
            <form action="">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Processing Type</label>
                            <select class="form-select form-control" name="" id="">
                                <option value="normal">Normal</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Travel Date</label>                            <input type="text" id="datepicker-time-start1" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">No. of Visa</label>
                            <select class="form-select form-control" name="" id="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="price">
                            <p>Price</p>
                            <span>IND {{ $visa->priceb2c }}</span>
                        </div>
                    </div>
                </div>
                <div class="formActions">
                    <!--<button class="">Enquire Now</button>-->
                    <a href="#" datapacid="{{$visa->id}}" data-toggle="modal"  data-target="#inquirymodal" class="visaBook">Enquire Now</a>
                    <!--<button class="btnFilled">Add to Cart</button>-->
                </div>
            </form>
        </div>

        <div class="card">
            <h4 class="card_title">{{ $visa->descritionTitle }}</h4>
            <p>{!! $visa->descrptionDetails !!}</p>
        </div>

        <div class="card">
            <h4 class="card_title">{{ $visa->clientsDocTitle }}</h4>
           {!! $visa->clientDoc_details !!}
        </div>

        <div class="card">
            <h4 class="card_title">{{ $visa->holida_assis_title }}</h4>
           {!! $visa->holiday_planer_Assest_details !!}
        </div>

        <div class="card">
            <h4 class="card_title">{{ $visa->special_note_title }}</h4>
            {!! $visa->special_note_details !!}
        </div>

        <div class="card">
            <h4 class="card_title">{{ $visa->how_to_ApplyTitle }}</h4>
             {!! $visa->how_to_apply_details !!}
        </div>

        <!--<div class="card">-->
        <!--    <h4 class="card_title">Frequently Asked Questions (FAQ)</h4>-->
       
        <!--    <div class="acc-container">-->
        <!--        <div class="acc">-->
        <!--            <div class="acc-head">-->
        <!--                <p>Lorem ipsum dolor sit amet.</p>-->
        <!--            </div>-->
        <!--            <div class="acc-content">-->
        <!--                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolore magnam, nobis consequuntur-->
        <!--                    nemo cupiditate vel sit ducimus quisquam quaerat sint officia ad voluptas consectetur beatae-->
        <!--                    quis illo accusamus vero odit, architecto et.</p>-->
        <!--            </div>-->
        <!--        </div>-->

        <!--        <div class="acc">-->
        <!--            <div class="acc-head">-->
        <!--                <p>Lorem ipsum dolor sit amet.</p>-->
        <!--            </div>-->
        <!--            <div class="acc-content">-->
        <!--                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolore magnam, nobis consequuntur-->
        <!--                    nemo cupiditate vel sit ducimus quisquam quaerat sint officia ad voluptas beatae eveniet.-->
        <!--                    Aliquam aspernatur nulla cupiditate reiciendis ut? Illum odio id odit? Tempore, ea itaque-->
        <!--                    illum laborum quasi, explicabo amet veritatis corporis dolorem minus commodi? Esse-->
        <!--                    repudiandae nam eligendi fugit, architecto quam! Nostrum dolores nisi nulla repudiandae sed-->
        <!--                    tempora impedit quaerat voluptatem itaque suscipit. Placeat adipisci, eius maiores-->
        <!--                    blanditiis possimus culpa? Laudantium officia, nulla repellat rerum tenetur esse quos-->
        <!--                    perferendis. Omnis corporis sequi, recusandae culpa quibusdam doloremque fugiat consectetur-->
        <!--                    beatae quis illo accusamus vero odit, architecto et.</p>-->
        <!--            </div>-->
        <!--        </div>-->

        <!--        <div class="acc">-->
        <!--            <div class="acc-head">-->
        <!--                <p>Lorem ipsum dolor sit amet.</p>-->
        <!--            </div>-->
        <!--            <div class="acc-content">-->
        <!--                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. doloremque fugiat consectetur-->
        <!--                    beatae quis illo accusamus vero odit, architecto et.</p>-->
        <!--            </div>-->
        <!--        </div>-->

        <!--        <div class="acc">-->
        <!--            <div class="acc-head">-->
        <!--                <p>Lorem ipsum dolor sit amet.</p>-->
        <!--            </div>-->
        <!--            <div class="acc-content">-->
        <!--                <p>Lorem ipsum, dolor sit amet consectetur am, nobis consequuntur nemo cupiditate vel sit-->
        <!--                    ducimus quisquam quaerat sint officia ad voluptas beatae eveniet. Aliquam aspernatur nulla-->
        <!--                    cupiditate reiciendis ut? Illum odio id odit? Tempore, ea itaque illum laborum quasi,-->
        <!--                    explicabo amet veritatis corporis dolorem minus commodi? Esse repudiandae nam eligendi-->
        <!--                    fugit, architecto quam! Nostrum dolores nisi nulla repudiandae sed tempora impedit quaerat-->
        <!--                    voluptatem itaque suscipit. Placeat adipisci, eius maiores blanditiis possimus culpa?-->
        <!--                    Laudantium officia, nulla repellat rerum tenetur esse quos perferendis. Omnis corporis-->
        <!--                    sequi, recusandae culpa quibusdam doloremque fugiat consectetur beatae quis illo accusamus-->
        <!--                    vero odit, architecto et.</p>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

   <!--     <div class="card testimonialsSect">-->
   <!--         <h4 class="card_title">-->
   <!--             Reviews-->
   <!--             <span class="reviewsCount">4/5 <i class="fas fa-star"></i></span>-->
   <!--         </h4>-->
			<!--<div id="testimonial-slider" class="owl-carousel">-->
   <!--     			   <div class="testimonial-item equal-height style-6">-->
   <!--     				   <div class="cell-right">-->
   <!--     					   <div class="testimonial-name">Whitney Dunn</div>-->
   <!--     				   </div>-->
   <!--     				   <div class="testimonial-content quote">-->
   <!--     						<i class="fa fa-quote-left"> </i>-->
   <!--     						Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt distinctio libero ipsam qui, porro vel? Ipsa delectus repellat quibusdam nostrum?-->
   <!--     				   </div>-->
   <!--     			   </div>-->
        			   
   <!--     			   <div class="testimonial-item equal-height style-6">-->
   <!--     				   <div class="cell-right">-->
   <!--     					   <div class="testimonial-name">Horace Briggs</div>-->
   <!--     				   </div>-->
   <!--     				   <div class="testimonial-content quote">-->
   <!--     						<i class="fa fa-quote-left"> </i>-->
   <!--     					   Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur debitis fugiat rerum aliquid eos numquam?-->
   <!--     				   </div>-->
   <!--     			   </div>-->
        			   
   <!--     			   <div class="testimonial-item equal-height style-6">-->
   <!--     				   <div class="cell-right">-->
   <!--     					   <div class="testimonial-name">Sophie Miller</div>-->
   <!--     				   </div>-->
   <!--     				   <div class="testimonial-content quote">-->
   <!--     						<i class="fa fa-quote-left"> </i>-->
   <!--     					   Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt distinctio libero ipsam qui, porro vel? Ipsa delectus repellat quibusdam nostrum?-->
   <!--     				   </div>-->
   <!--     			   </div>-->
        			   
   <!--     			   <div class="testimonial-item equal-height style-6">-->
   <!--     				   <div class="cell-right">-->
   <!--     					   <div class="testimonial-name">Beata Lowe</div>-->
   <!--     				   </div>-->
   <!--     				   <div class="testimonial-content quote">-->
   <!--     						<i class="fa fa-quote-left"> </i>-->
   <!--     						Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt distinctio libero ipsam qui, porro vel? Ipsa delectus repellat quibusdam nostrum?-->
   <!--     				   </div>-->
   <!--     			   </div>-->
        			   
   <!--     			   <div class="testimonial-item equal-height style-6">-->
   <!--     				   <div class="cell-right">-->
   <!--     					   <div class="testimonial-name">Zachary Coleman</div>-->
   <!--     				   </div>-->
   <!--     				   <div class="testimonial-content quote">-->
   <!--     						<i class="fa fa-quote-left"> </i>-->
   <!--     					   Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor natus eum exercitationem at expedita totam aspernatur, incidunt nulla?-->
   <!--     				   </div>-->
   <!--     			   </div>-->
        			   
   <!--     		   </div>-->
   <!--     </div>-->

        <div class="card">
            <h4 class="card_title">{{ $visa->visa_info_title }}</h4>
            <h6>On Arrival Visa Country </h6>
                
            <div class="table-responsive">
               {!! $visa->visa_info_details !!}
            </div>
            
        </div>
        
        <div class="card">
            <h4 class="card_title">{{ $visa->terms_condition_title }}</h4>
                
               {!! $visa->term_condition_Details !!}
            
        </div> 
        
        <div class="card">
            <h4 class="card_title">{{ $visa->holiday_list_title }}</h4>
            <h6>Expected Public Holidays For 2023.</h6>
                
            <div class="table-responsive">
                 {!! $visa->holiday_list_details !!}
            </div>
            
        </div>

    </div>
    
<div class="modal fade" id="inquirymodal" tabindex="-1" role="dialog" aria-labelledby="inquirymodalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="inquirymodalLabel">Quick Inquiry</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="pkgform-wrapper">
						<div class="cont-wth1">
							<div class="pkgform-headbx text-center">Quick Enquiry <span class="title-arrow"></span></div>
							<div class="pkgform-box">
  <?php use App\Http\Controllers\Controller;
  $country = Controller::getnationalityRe(); ?>
								{{ Form::open(array('url' => 'visa/save', 'name'=>"queryform", 'autocomplete'=>'off','id'=>'popenquiryco')) }}
								<span class="customerror"></span>
								<input type="text" data-valid='required' name="name" class="form-control" value="" placeholder="Name">
								<input type="text" data-valid='required' name="email" class="form-control" value="" placeholder="Email">
								<input type="text" data-valid='required' name="phone" class="form-control" value="" placeholder="Phone">
								<!--<input type="text" data-valid='required' name="city" class="form-control" value="" placeholder="City">-->
								<select class="form-select form-control" name="visa_for" id="">
                                    <option value="" selected disabled>Visa For</option>
                                    @if($country)
                                    @foreach($country as $count)
                                    <option value="{{$count->id}} ">{{$count->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
								<div class="form-group">
									<input type="date"    data-valid='required' name="traveldate" class="form-control" value="" placeholder="Visa Date">
								</div>
								<textarea class="form-control" type="text" name="add_info" placeholder="Put Your Remark Here."></textarea>
								<input type="hidden" id="mpackage_id" name="package_id" value="">
								{{ Form::button('Submit', ['class'=>'submitbtt', 'onClick'=>'customValidate("queryform")' ]) }}
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    
    
    @endsection
@section('scripts')
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>


    <script>
    

// *** Form Datepicker *** //
function formDatepicker() {

	var dateToday = new Date();
	var dateAsYMD = new Date();

	var month = dateAsYMD.getMonth() + 1;
	var day = dateAsYMD.getDate();

	var outputDateAsYMD = dateAsYMD.getFullYear() + '/' +
		(('' + month).length < 2 ? '0' : '') + month + '/' +
		(('' + day).length < 2 ? '0' : '') + day;

	// alert(outputDateAsYMD);

	$("#datepicker-time-start1").attr("placeholder", outputDateAsYMD);
	var dates = $("#datepicker-time-start1").datepicker({
		defaultDate: "+2d",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: 'yy/mm/dd',
		minDate: dateToday,
		onSelect: function (selectedDate) {
			var option = this.id == "datepicker-time-start1" ? "minDate" : "maxDate",
				instance = $(this).data("datepicker"),
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker("option", option, date);
		}
	});
	$("#datepicker-time-start2").attr("placeholder", outputDateAsYMD);
	var dates = $("#datepicker-time-start2").datepicker({
		defaultDate: "+2d",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: 'yy/mm/dd',
		minDate: dateToday,
		onSelect: function (selectedDate) {
			var option = this.id == "datepicker-time-start2" ? "minDate" : "maxDate",
				instance = $(this).data("datepicker"),
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker("option", option, date);
		}
	});

	$(".datepicker-2-time-start").datepicker({
		dateFormat: 'yy/mm/dd'
	});
}
        $(document).ready(function () {
            
            // accordion function
            $('.acc-container .acc:nth-child(1) .acc-head').addClass('active');
            $('.acc-container .acc:nth-child(1) .acc-content').slideDown();
            $('.acc-head').on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).siblings('.acc-content').slideUp();
                    $(this).removeClass('active');
                }
                else {
                    $('.acc-content').slideUp();
                    $('.acc-head').removeClass('active');
                    $(this).siblings('.acc-content').slideToggle();
                    $(this).toggleClass('active');
                }
            });
        
            
            
        // reviews slider
        $("#testimonial-slider").owlCarousel({
			loop: true,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:2,
					nav:false
				},
				1000:{
					items:3,
					nav:true,
					loop:false
				}
			},			
			pagination:false,
			navigation:false,
			autoPlay:true,
		});

        });
    </script>
    


@endsection