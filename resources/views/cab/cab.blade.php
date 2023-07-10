@extends('layouts.frontend') @section('title', @$seoDetails->meta_title) @section('meta_title', @$seoDetails->meta_title) @section('meta_keyword', @$seoDetails->meta_keyword) @section('meta_description', @$seoDetails->meta_desc)
@section('bodyclass', 'homepage') @section('pagespecificstyles') @endsection @section('content')
<?php use App\Http\Controllers\PackageController; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!-- Banner
============================================= -->
<style>
    .promocode_desc {
        border: 1px dashed #a7a7a7;
        border-radius: 4px;
        display: inline-flex;
        position: relative;
        margin-top: 15px;
    }
    .promcde {
        background: #2196f3;
        border-radius: 20px;
        text-align: center;
        padding: 1px 5px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        color: #fff;
        position: absolute;
        top: -11px;
        left: 7px;
    }
    .coupncde {
        font-size: 13px;
        color: #000;
        font-weight: 600;
        text-transform: uppercase;
        padding: 6px 8px;
        display: flex;
        border-right: 1px dashed #a7a7a7;
    }
    
    @media(max-widht: 1200px){
        .cab_banner .form-group.cus_searchbtn_field.btncng_ser {
            bottom: -90px;
        }
    }
    
    @media(max-width: 991px){
        .cab_banner .form-group.cus_searchbtn_field.btncng_ser {
            bottom: -120px;
        }
        
        .cardhow_works{
            margin-bottom: 30px;
        }
        
        
        .testimonials {
            padding-top: 0;
        }
            
    }
    
</style>

<div class="mob_flight_link">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 padd0">
                <div class="flight_link">
                    <ul>
                        <li>
                            <a href="{{URL::to('/')}}"><img src="{{ asset('public/images/icons/flight-tab.png') }}" alt="" /> Flight</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/hotels')}}"><img src="{{  asset('public/images/icons/hotel-tab.png') }}" alt="" /> Hotels</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="banner">
    <div class="banner-parallax cab_banner">
        <div class="overlay-colored color-bg-white"></div>
        <div class="slide-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner-center-box">
                            <div class="banner-reservation-tabs custom_reservation_tab cabBannerForm">
                                <ul class="br-tabs">
                                    <li class="active" dataway="oneway"><a href="javascript:;">One Way</a></li>
                                    <li dataway="multicity"><a href="javascript:;">Roundtrip</a></li>
                                </ul>

                                <ul class="br-tabs-content">
                                    <li class="roundandoneway commonway active" style="display: list-item;">
                                        <div class="ismultipleway">
                                            <form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-50">
                                                <div class="form-group loc_search_field cus_loc_field">
                                                    <input type="hidden" id="roundfromsearch" />
                                                    <input type="hidden" id="journey_type" value="1" />
                                                    <input style="cursor: text;" autocomplete="off" type="text" name="roundwayfrmtext" id="fromdest_show" class="br_right roundwayfrom form-control wrapper-dropdown-2" placeholder="Source City" />
                                                    <i class="fa fa-taxi" aria-hidden="true"></i>

                                                </div>
                                                
                                                <!-- .form-group end -->
                                                <div class="form-group loc_search_field_to cus_loc_field">
                                                    <input type="hidden" id="roundtosearch" />
                                                    <input style="cursor: text;" autocomplete="off" type="text" name="roundwaytotext" id="todest_show" class="roundwayto form-control wrapper-dropdown-3" placeholder="Destination City" />
                                                    <i class="fa fa-taxi" aria-hidden="true"></i>

                                                    <div class="location_search_to selhide" id="location_search_to">
                                                        <div class="inner_loc_search">
                                                            <div class="top_city">
                                                                <span>Top Cities</span>
                                                            </div>
                                                            <ul class="is_search_to_val">
                                                                @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $elist)
                                                                <li roundwaytotop="{{$elist->city_code}}-{{$elist->city_name}}-{{$elist->country_name}}" roundwayto="{{$elist->city_name}}({{$elist->city_code}})">
                                                                    <div class="fli_name"><i class="fa fa-plane"></i> {{$elist->city_name}} ({{$elist->city_code}})</div>
                                                                    <div class="airport_name">{{$elist->airport_name}}<span>{{$elist->country_name}}</span></div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" placeholder="Start Date" />
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                               <!-- .form-group end -->
                                               <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" placeholder="Start Time" />
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                </div>

                                                <a style="display: none;" class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark" href="javascript:;">
                                                    <i class="fas fa-plus"></i>
                                                    Add City
                                                </a>
                                                <div class="clearfix"></div>

                                                <div class="form-group cus_searchbtn_field btncng_ser">
                                                    <button type="button" class="form-control roundformsearch icon"><i class="fas fa-search"></i> Search Cabs</button>
                                                </div>
                                            </form>
                                            <!-- .form-banner-reservation end -->
                                        </div>
                                    </li>

                                    <li class="multiwaytrip commonway mtlc" style="display: none;">
                                        <form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-50">
                                                <div class="form-group loc_search_field cus_loc_field">
                                                    <input type="hidden" id="roundfromsearch" />
                                                    <input type="hidden" id="journey_type" value="1" />
                                                    <input style="cursor: text;" autocomplete="off" type="text" name="roundwayfrmtext" id="fromdest_show" class="br_right roundwayfrom form-control wrapper-dropdown-2" placeholder="Source City" />
                                                    <i class="fa fa-taxi" aria-hidden="true"></i>

                                                </div>
                                                
                                                <!-- .form-group end -->
                                                <div class="form-group loc_search_field_to cus_loc_field">
                                                    <input type="hidden" id="roundtosearch" />
                                                    <input style="cursor: text;" autocomplete="off" type="text" name="roundwaytotext" id="todest_show" class="roundwayto form-control wrapper-dropdown-3" placeholder="Destination City" />
                                                    <i class="fa fa-taxi" aria-hidden="true"></i>

                                                    <div class="location_search_to selhide" id="location_search_to">
                                                        <div class="inner_loc_search">
                                                            <div class="top_city">
                                                                <span>Top Cities</span>
                                                            </div>
                                                            <ul class="is_search_to_val">
                                                                @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $elist)
                                                                <li roundwaytotop="{{$elist->city_code}}-{{$elist->city_name}}-{{$elist->country_name}}" roundwayto="{{$elist->city_name}}({{$elist->city_code}})">
                                                                    <div class="fli_name"><i class="fa fa-plane"></i> {{$elist->city_name}} ({{$elist->city_code}})</div>
                                                                    <div class="airport_name">{{$elist->airport_name}}<span>{{$elist->country_name}}</span></div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" placeholder="Start Date" />
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                                
                                                <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" placeholder="End Date" />
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                               <!-- .form-group end -->
                                               <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" placeholder="Start Time" />
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                </div>

                                                <a style="display: none;" class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark" href="javascript:;">
                                                    <i class="fas fa-plus"></i>
                                                    Add City
                                                </a>
                                                <div class="clearfix"></div>

                                                <div class="form-group cus_searchbtn_field btncng_ser">
                                                    <button type="button" class="form-control roundformsearch icon"><i class="fas fa-search"></i> Search Cabs</button>
                                                </div>
                                            </form>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <!-- .banner-reservation-tabs end -->
                        </div>
                        <!-- .banner-center-box end -->
                    </div>
                    <!-- .col-md-12 end -->
                </div>
                <!-- .row end -->
            </div>
            <!-- .container end -->
        </div>
        <!-- .slide-content end -->
    </div>
    <!-- .banner-parallax end -->
</section>
<!-- #banner end -->

<div class="container cabsContent">
    <h3 class="text-center">How it works</h3>
    <p class="text-center">Book a taxi in 3 easy steps</p>
    
    <div class="row howWorksRow">
        <div class="col-md-4">
            <div class="cardhow_works">
                <img class="img-fluid" src="{{  asset('public/img/select_cabs.png')}}" alt="Search Cabs" />
                <h4>Search</h4>
                <p>Local, Outstation, Transfer or Oneway Drop simply select your trip type.</p>
            </div>
        </div>
            
        <div class="col-md-4">
            <div class="cardhow_works">
                <h4>Select Cab</h4>
                <img class="img-fluid" src="{{  asset('public/img/search_cabs.png')}}" alt="Select Cabs" />
                <p>Choose from a wide range of fleets that will suit your travel needs.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="cardhow_works">
                <img class="img-fluid" src="{{  asset('public/img/check.png')}}" alt="Select Cabs" />            
                <h4>Pay & Book</h4>
                <p>Confirm your booking by securely paying with flexible payment options.</p>
            </div>
        </div>
    </div>   
</div>

<div class="container testimonials">
    <h3 class="text-center">What customer say</h3>
    <p class="text-center">Book a taxi in 3 easy steps</p>
    
    <div class="owl-carousel client-testimonial-carousel">
        <div class="single-testimonial-item">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet ex labore id beatae molestiae, libero quis eum nam voluptates quidem.</p>
            <h3>Jenson Bishop</h3>
        </div>
        
        <div class="single-testimonial-item">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Eveniet ex labore id beatae molestiae, libero quis eum nam voluptates quidem.</p>
            <h3>Floyd Elliott</h3>
        </div>
        
        <div class="single-testimonial-item">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Eveniet ex labore id beatae molestiae, libero quis eum nam voluptates quidem.</p>
            <h3>Patricia Tomlinson</h3>
        </div>
        
        <div class="single-testimonial-item">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Eveniet ex labore id beatae molestiae, libero quis eum nam voluptates quidem.</p>
            <h3>Wayne Gutierrez</h3>
        </div>
        
        <div class="single-testimonial-item">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Eveniet ex labore id beatae molestiae, libero quis eum nam voluptates quidem.</p>
            <h3>Danielle Kelley</h3>
        </div>

    </div>
</div>

<!-- Content
		============================================= -->
<section id="content">
    <div id="content-wrap">
        <!-- === Section Top Destinations =========== -->
        <div id="section-top-destintations" class="section-flat hidden">
            <div class="section-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title">
                                <h2><strong>Top</strong> Destinations</h2>
                            </div>
                            <!-- .section-title end -->
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container end -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="slider-top-destinations">
                                <ul class="slick-slider">
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-2.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">South America</a></h5>
                                                    <h6>3 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-3.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">Europe</a></h5>
                                                    <h6>7 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-5.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">Aisa</a></h5>
                                                    <h6>2 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-6.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">Africa</a></h5>
                                                    <h6>5 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-4.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">Australia</a></h5>
                                                    <h6>6 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-2.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">South America</a></h5>
                                                    <h6>3 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                    <li>
                                        <div class="box-preview box-area-destination">
                                            <div class="box-img img-bg">
                                                <a href="javascript:;"><img src="{!! asset('public/images/img-3.jpg') !!}" alt="" /></a>
                                                <div class="overlay">
                                                    <div class="overlay-inner"></div>
                                                    <!-- .overlay-inner end -->
                                                </div>
                                                <!-- .overlay end -->
                                            </div>
                                            <!-- .box-img end -->
                                            <div class="box-content">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="title">
                                                    <h5><a href="javascript:;">Europe</a></h5>
                                                    <h6>7 Tours</h6>
                                                </div>
                                                <!-- .title end -->
                                            </div>
                                            <!-- .box-content end -->
                                        </div>
                                        <!-- .box-preview end -->
                                    </li>
                                </ul>
                                <!-- .slick-slider end -->
                                <div class="slick-arrows"></div>
                                <!-- .slick-arrows end -->
                            </div>
                            <!-- .slider-top-destinations end -->
                        </div>
                        <!-- .col-md-12 end -->
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container end -->
            </div>
            <!-- .section-content end -->
        </div>
        <!-- .section-flat end -->
    </div>
    <!-- #content-wrap -->
</section>
<!-- #content end -->

<section class="subscribe-area pb-50 pt-70">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="subscribe-text">
                    <span>Coupons, Special Offers and Promotions.</span>
                    <h2>Sign up for Exclusive Offers</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="subscribe-wrapper subscribe2-wrapper">
                    <div class="subscribe-form">
                        <form action="#">
                            <input placeholder="Enter your email address" type="email" />
                            <button>subscribe <i class="fas fa-long-arrow-alt-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="mob_sticky_menu">
    <div class="container">
        <div class="row">
            <ul>
                <li>
                    <a href="{{URL::to('/')}}"><i class="fa fa-home"></i> Home</a>
                </li>
                @if(Auth::user())
                <li>
                    <a href="{{URL::to('/my-profile')}}" class=""><i class="fa fa-user"></i> My Account</a>
                </li>
                @else
                <li>
                    <a href="#" class="popup-btn-login"><i class="fa fa-user"></i> My Account</a>
                </li>
                @endif @if(Auth::user())
                <li>
                    <a href="{{URL::to('/user')}}"><i class="fa fa-calendar"></i> My Booking</a>
                </li>
                @else
                <li>
                    <a href="#"><i class="fa fa-calendar"></i> My Booking</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function(){
  $(".owl-carousel").owlCarousel({
      items:3,
      autoplay:true,
      margin:30,
      loop:true,
      dots:true,
      
      responsive: {
        0:{
          items: 1
        },
        480:{
          items: 1
        },
        769:{
          items: 2
        }
    }
  });
});
</script>

@endsection


