@extends('layouts.frontend') @section('title', @$seoDetails->meta_title) @section('meta_title', @$seoDetails->meta_title) @section('meta_keyword', @$seoDetails->meta_keyword) @section('meta_description', @$seoDetails->meta_desc)
@section('bodyclass', 'homepage') @section('pagespecificstyles') @endsection @section('content')
<?php use App\Http\Controllers\PackageController; ?>

<style>
    .active {
        display: block;
    }

    .hide {
        display: none;
    }

    .flights_offer_tabs {
        padding: 0px;
        list-style: none;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .flights_offers_section {
        padding: 30px;
        margin: 40px 0;
        border-radius: 4px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
        display: none;
    }

    .tab_link_wrapper a {
        font-size: 16px;
        color: #222;
        font-weight: 500;
        border-bottom: 2px solid transparent;
        transition: 0.5s all ease;
    }

    .tab_link_wrapper a.activelink,
    .tab_link_wrapper a:hover {
        color: #4373b5;
        border-color: #4373b5;
    }

    .flights_offer_tabs h4 {
        margin-bottom: 0;
        margin-right: 20px;
    }

    .card {
        border-radius: 4px;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
    }

    .card-body {
        padding: 15px;
    }

    .offer_details {
        display: flex;
        gap: 20px;
    }

    .offerImg {
        height: 130px;
        width: 130px;
    }

    .offerImg img {
        width: 100%;
        height: auto;
    }

    .offerOptions a {
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .offerText h5 {
        margin-bottom: 2px;
    }

    .offerText p {
        color: #222;
    }
</style>

<div class="mob_flight_link">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 padd0">
                <div class="flight_link">
                    <ul>
                        <li>
                            <a href="{{URL::to('/')}}"><img src="{!! asset('public/images/icons/flight-tab.png') !!}" alt="" /> Flight</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/hotels')}}"><img src="{!! asset('public/images/icons/hotel-tab.png') !!}" alt="" /> Hotels</a>
                        </li>
                        <!--<li><a href="#"><img src="{!! asset('public/images/icons/holiday-tab.png') !!}" alt=""/> Holiday</a></li>
						<li><a href="#"><img src="{!! asset('public/images/icons/bus-tab.png') !!}" alt=""/> Bus</a></li>
						<li><a href="#"><img src="{!! asset('public/images/icons/visa-tab.png') !!}" alt=""/> Visa</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="banner">
    <div class="banner-parallax">
        <!-- <img src="{!! asset('public/images/home-banner-bg.jpg') !!}" alt=""> -->
        <div class="overlay-colored color-bg-white"></div>
        <!-- .overlay-colored end -->
        <div class="slide-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner-center-box">
                            <div class="banner-reservation-tabs custom_reservation_tab">
                                <ul class="br-tabs">
                                    <li class="active" dataway="oneway"><a href="javascript:;">One Way</a></li>
                                    <li class="roundtriptab" dataway="roundtrip"><a href="javascript:;">Round Trip</a></li>
                                    <li dataway="multicity"><a href="javascript:;">Multi City</a></li>
                                </ul>
                                <!-- .br-tabs end -->

                                <ul class="br-tabs-content">
                                    <li class="roundandoneway commonway active" style="display: list-item;">
                                        <div class="ismultipleway">
                                            <form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-50">
                                                <div class="form-group loc_search_field cus_loc_field">
                                                    <input type="hidden" id="roundfromsearch" />
                                                    <input type="hidden" id="journey_type" value="1" />
                                                    <input style="cursor: text;" autocomplete="off" type="text" name="roundwayfrmtext" id="fromdest_show" class="br_right roundwayfrom form-control wrapper-dropdown-2" placeholder="From" />
                                                    <i class="fas fa-plane"></i>
                                                    <div class="location_search selhide" id="location_search">
                                                        <div class="inner_loc_search">
                                                            <div class="top_city">
                                                                <span>Top Cities</span>
                                                            </div>
                                                            <ul class="is_search_from_val">
                                                                @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                    <div class="fli_name">
                                                                        <i class="fa fa-plane"></i>
                                                                        {{$alist->city_name}} ({{$alist->city_code}})
                                                                    </div>
                                                                    <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group loc_search_field_to cus_loc_field">
                                                    <input type="hidden" id="roundtosearch" />
                                                    <input style="cursor: text;" autocomplete="off" type="text" name="roundwaytotext" id="todest_show" class="roundwayto form-control wrapper-dropdown-3" placeholder="To" />
                                                    <i class="fas fa-plane"></i>
                                                    <div class="location_search_to selhide" id="location_search_to">
                                                        <div class="inner_loc_search">
                                                            <div class="top_city">
                                                                <span>Top Cities</span>
                                                            </div>
                                                            <ul class="is_search_to_val">
                                                                @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $elist)
                                                                <li roundwaytotop="{{$elist->city_code}}-{{$elist->city_name}}-{{$elist->country_name}}" roundwayto="{{$elist->city_name}}({{$elist->city_code}})">
                                                                    <div class="fli_name">
                                                                        <i class="fa fa-plane"></i>
                                                                        {{$elist->city_name}} ({{$elist->city_code}})
                                                                    </div>
                                                                    <div class="airport_name">{{$elist->airport_name}}<span>{{$elist->country_name}}</span></div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="datepicker-time-start" placeholder="2019/09/30" />
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group hideifmulticity cus_calendar_field" style="opacity: 0.4;">
                                                    <input autocomplete="off" readonly type="text" name="brTimeEnd" value="" class="form-control if_oneway_trip roundtripenable" id="datepicker-time-end" placeholder="2019/09/30" />
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group roundtrip cus_passenger_field">
                                                    <input
                                                        autocomplete="off"
                                                        type="text"
                                                        id="roundpessanger"
                                                        name="brPassengerNumber"
                                                        class="right_rus form-control show-dropdown-passengers roundpessanger"
                                                        placeholder="Passengers"
                                                        value="1 Passengers"
                                                    />
                                                    <i class="fas fa-user"></i>
                                                    <ul class="list-dropdown-passengers">
                                                        <li>
                                                            <ul class="list-persons-count">
                                                                <li>
                                                                    <span>Adults:</span>
                                                                    <div class="counter-add-item">
                                                                        <a class="decrease-btn" href="javascript:;">-</a>
                                                                        <input id="roundadult" class="onewayadult" type="text" value="1" />
                                                                        <a class="increase-btn" href="javascript:;">+</a>
                                                                    </div>
                                                                    <!-- .counter-add-item end -->
                                                                </li>
                                                                <li>
                                                                    <span>Childs:</span>
                                                                    <div class="counter-add-item">
                                                                        <a class="decrease-btn" href="javascript:;">-</a>
                                                                        <input id="roundchild" class="onewaychild" type="text" value="0" />
                                                                        <a class="increase-btn" href="javascript:;">+</a>
                                                                    </div>
                                                                    <!-- .counter-add-item end -->
                                                                </li>
                                                                <li>
                                                                    <span>Infants:</span>
                                                                    <div class="counter-add-item">
                                                                        <a class="decrease-btn" href="javascript:;">-</a>
                                                                        <input id="roundinfant" class="onewayinfants" type="text" value="0" />
                                                                        <a class="increase-btn" href="javascript:;">+</a>
                                                                    </div>
                                                                    <!-- .counter-add-item end -->
                                                                </li>
                                                            </ul>
                                                            <!-- .list-persons-count end -->
                                                        </li>
                                                        <li>
                                                            <a class="btn-reservation-passengers btn x-small colorful hover-dark" href="javascript:;">Done</a>
                                                        </li>
                                                    </ul>
                                                    <!-- .list-dropdown-passengers end -->
                                                </div>
                                                <!-- .form-group end -->
                                                <!-- .form-group end -->
                                                <a style="display: none;" class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark" href="javascript:;">
                                                    <i class="fas fa-plus"></i>
                                                    Add City
                                                </a>
                                                <div class="clearfix"></div>

                                                <div class="form-group cus_searchbtn_field btncng_ser">
                                                    <button type="button" class="form-control roundformsearch icon"><i class="fas fa-search"></i> Search Flights</button>
                                                </div>
                                            </form>
                                            <!-- .form-banner-reservation end -->
                                        </div>
                                    </li>

                                    <li class="multiwaytrip commonway mtlc" style="display: none;">
                                        <form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-50">
                                            <div class="ismultipleway mb-10" id="section-s1">
                                                <div class="form-group loc_search_field cus_loc_field">
                                                    <input type="hidden" id="multi_roundfromsearch1" />
                                                    <input type="hidden" id="journey_type" value="3" />
                                                    <input
                                                        did="s1"
                                                        ssid="1"
                                                        style="cursor: text;"
                                                        autocomplete="off"
                                                        type="text"
                                                        name="multiwayfromtext1"
                                                        id="fromdest_show1"
                                                        class="br_right multi_roundwayfrom form-control wrapper-dropdown-7"
                                                        placeholder="From"
                                                    />
                                                    <i class="fas fa-plane"></i>
                                                    <div class="location_search selhide" id="location_search">
                                                        <div class="inner_loc_search">
                                                            <div class="top_city">
                                                                <span>Top Cities</span>
                                                            </div>
                                                            <ul class="multi_is_search_from_val">
                                                                @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                    <div class="fli_name">
                                                                        <i class="fa fa-plane"></i>
                                                                        {{$alist->city_name}} ({{$alist->city_code}})
                                                                    </div>
                                                                    <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group loc_search_field_to cus_loc_field">
                                                    <input type="hidden" id="multi_roundtosearch1" />
                                                    <input
                                                        did="s1"
                                                        ssid="1"
                                                        style="cursor: text;"
                                                        autocomplete="off"
                                                        type="text"
                                                        name="multiwaytotext1"
                                                        id="todest_show1"
                                                        class="multi_roundwayto form-control wrapper-dropdown-8"
                                                        placeholder="To"
                                                    />
                                                    <i class="fas fa-plane"></i>
                                                    <div class="location_search_to selhide" id="location_search_to">
                                                        <div class="inner_loc_search">
                                                            <div class="top_city">
                                                                <span>Top Cities</span>
                                                            </div>
                                                            <ul class="multi_is_search_to_val">
                                                                @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $elist)
                                                                <li roundwaytotop="{{$elist->city_code}}-{{$elist->city_name}}-{{$elist->country_name}}" roundwayto="{{$elist->city_name}}({{$elist->city_code}})">
                                                                    <div class="fli_name">
                                                                        <i class="fa fa-plane"></i>
                                                                        {{$elist->city_name}} ({{$elist->city_code}})
                                                                    </div>
                                                                    <div class="airport_name">{{$elist->airport_name}}<span>{{$elist->country_name}}</span></div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group cus_calendar_field">
                                                    <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker1" placeholder="2019/09/30" />
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                                <!-- .form-group end -->

                                                <div class="form-group multiroundtrip cus_passenger_field">
                                                    <input
                                                        autocomplete="off"
                                                        type="text"
                                                        id="multiroundpessanger"
                                                        name="multibrPassengerNumber"
                                                        class="right_rus form-control show-dropdown-passengers multiroundpessanger"
                                                        placeholder="Passengers"
                                                        value="1 Passengers"
                                                    />
                                                    <i class="fas fa-user"></i>
                                                    <ul class="list-dropdown-passengers">
                                                        <li>
                                                            <ul class="list-persons-count">
                                                                <li>
                                                                    <span>Adults:</span>
                                                                    <div class="counter-add-item">
                                                                        <a class="multidecrease-btn" href="javascript:;">-</a>
                                                                        <input id="multiroundadult" class="multionewayadult" type="text" value="1" />
                                                                        <a class="multiincrease-btn" href="javascript:;">+</a>
                                                                    </div>
                                                                    <!-- .counter-add-item end -->
                                                                </li>
                                                                <li>
                                                                    <span>Childs:</span>
                                                                    <div class="counter-add-item">
                                                                        <a class="multidecrease-btn" href="javascript:;">-</a>
                                                                        <input id="multiroundchild" class="multionewaychild" type="text" value="0" />
                                                                        <a class="multiincrease-btn" href="javascript:;">+</a>
                                                                    </div>
                                                                    <!-- .counter-add-item end -->
                                                                </li>
                                                                <li>
                                                                    <span>Infants:</span>
                                                                    <div class="counter-add-item">
                                                                        <a class="multidecrease-btn" href="javascript:;">-</a>
                                                                        <input id="multiroundinfant" class="multionewayinfants" type="text" value="0" />
                                                                        <a class="multiincrease-btn" href="javascript:;">+</a>
                                                                    </div>
                                                                    <!-- .counter-add-item end -->
                                                                </li>
                                                            </ul>
                                                            <!-- .list-persons-count end -->
                                                        </li>
                                                        <li>
                                                            <a class="btn-reservation-passengers btn x-small colorful hover-dark" href="javascript:;">Done</a>
                                                        </li>
                                                    </ul>
                                                    <!-- .list-dropdown-passengers end -->
                                                </div>
                                                <!-- .form-group end -->
                                                <div class="form-group cus_searchbtn_field mltybtn">
                                                    <button type="button" class="form-control multiroundformsearch icon" onClick="ValidateMuticity()"><i class="fas fa-search"></i> Search Flights</button>
                                                </div>
                                                <!-- .form-group end -->
                                                <a id="crs1" onclick="CloseSection('section-s1','')" class="closem" style="display: none;" href="javascript:;">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="scrol_tb">
                                                <div class="ismultipleway mb-10" id="section-s2">
                                                    <div class="form-group loc_search_field cus_loc_field">
                                                        <input type="hidden" id="multi_roundfromsearch2" />

                                                        <input
                                                            did="s2"
                                                            ssid="2"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwayfromtext2"
                                                            id="fromdest_show2"
                                                            class="br_right multi_roundwayfrom form-control wrapper-dropdown-8"
                                                            placeholder="From"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search selhide" id="location_search">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_from_val">
                                                                    @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                    <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                        <div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
                                                                        <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
                                                    </div>
                                                    <!-- .form-group end -->
                                                    <div class="form-group loc_search_field_to cus_loc_field">
                                                        <input type="hidden" id="multi_roundtosearch2" />
                                                        <input
                                                            did="s2"
                                                            ssid="2"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwaytotext2"
                                                            id="todest_show2"
                                                            class="multi_roundwayto form-control wrapper-dropdown-9"
                                                            placeholder="To"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search_to selhide" id="location_search_to">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_to_val">
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
                                                        <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker2" placeholder="2019/09/30" />
                                                        <i class="far fa-calendar"></i>
                                                    </div>
                                                    <!-- .form-group end -->

                                                    <a id="crs2" onclick="CloseSection('section-s2','')" class="closem" style="display: none;" href="javascript:;">
                                                        <i class="fas fa-times"></i>
                                                    </a>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="ismultipleway mb-10" id="section-s3" style="display: none;">
                                                    <div class="form-group loc_search_field cus_loc_field">
                                                        <input type="hidden" id="multi_roundfromsearch3" />

                                                        <input
                                                            did="s3"
                                                            ssid="3"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwayfromtext3"
                                                            id="fromdest_show3"
                                                            class="br_right multi_roundwayfrom form-control wrapper-dropdown-10"
                                                            placeholder="From"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search selhide" id="location_search">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_from_val">
                                                                    @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                    <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                        <div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
                                                                        <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
                                                    </div>
                                                    <!-- .form-group end -->
                                                    <div class="form-group loc_search_field_to cus_loc_field">
                                                        <input type="hidden" id="multi_roundtosearch3" />
                                                        <input
                                                            did="s3"
                                                            ssid="3"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwaytotext3"
                                                            id="todest_show3"
                                                            class="multi_roundwayto form-control wrapper-dropdown-11"
                                                            placeholder="To"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search_to selhide" id="location_search_to">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_to_val">
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
                                                        <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker3" placeholder="2019/09/30" />
                                                        <i class="far fa-calendar"></i>
                                                    </div>
                                                    <!-- .form-group end -->

                                                    <a id="crs3" onclick="CloseSection('section-s3','')" class="closem" href="javascript:;">
                                                        <i class="fas fa-times"></i>
                                                    </a>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="ismultipleway mb-10" id="section-s4" style="display: none;">
                                                    <div class="form-group loc_search_field cus_loc_field">
                                                        <input type="hidden" id="multi_roundfromsearch4" />

                                                        <input
                                                            did="s4"
                                                            ssid="4"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwayfromtext4"
                                                            id="fromdest_show4"
                                                            class="br_right multi_roundwayfrom form-control wrapper-dropdown-12"
                                                            placeholder="From"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search selhide" id="location_search">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_from_val">
                                                                    @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                    <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                        <div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
                                                                        <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
                                                    </div>
                                                    <!-- .form-group end -->
                                                    <div class="form-group loc_search_field_to cus_loc_field">
                                                        <input type="hidden" id="multi_roundtosearch4" />
                                                        <input
                                                            did="s4"
                                                            ssid="4"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwaytotext4"
                                                            id="todest_show4"
                                                            class="multi_roundwayto form-control wrapper-dropdown-13"
                                                            placeholder="To"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search_to selhide" id="location_search_to">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_to_val">
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
                                                        <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker4" placeholder="2019/09/30" />
                                                        <i class="far fa-calendar"></i>
                                                    </div>
                                                    <!-- .form-group end -->

                                                    <a id="crs4" class="closem" onclick="CloseSection('section-s4',3)" href="javascript:;">
                                                        <i class="fas fa-times"></i>
                                                    </a>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="ismultipleway mb-10" id="section-s5" style="display: none;">
                                                    <div class="form-group loc_search_field cus_loc_field">
                                                        <input type="hidden" id="multi_roundfromsearch5" />

                                                        <input
                                                            did="s5"
                                                            ssid="5"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwayfromtext5"
                                                            id="fromdest_show5"
                                                            class="br_right multi_roundwayfrom form-control wrapper-dropdown-14"
                                                            placeholder="From"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search selhide" id="location_search">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_from_val">
                                                                    @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                    <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                        <div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
                                                                        <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
                                                    </div>
                                                    <!-- .form-group end -->
                                                    <div class="form-group loc_search_field_to cus_loc_field">
                                                        <input type="hidden" id="multi_roundtosearch5" />
                                                        <input
                                                            did="s5"
                                                            ssid="5"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwaytotext5"
                                                            id="todest_show5"
                                                            class="multi_roundwayto form-control wrapper-dropdown-15"
                                                            placeholder="To"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search_to selhide" id="location_search_to">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_to_val">
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
                                                        <input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker5" placeholder="2019/09/30" />
                                                        <i class="far fa-calendar"></i>
                                                    </div>
                                                    <!-- .form-group end -->

                                                    <a id="crs5" onclick="CloseSection('section-s5',4)" class="closem" href="javascript:;">
                                                        <i class="fas fa-times"></i>
                                                    </a>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="ismultipleway mb-10" id="section-s6" style="display: none;">
                                                    <div class="form-group loc_search_field cus_loc_field">
                                                        <input type="hidden" id="multi_roundfromsearch6" />
                                                        <input type="hidden" id="journey_type" value="3" />
                                                        <input
                                                            did="s6"
                                                            ssid="6"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwayfromtext6"
                                                            id="fromdest_show6"
                                                            class="br_right multi_roundwayfrom form-control wrapper-dropdown-16"
                                                            placeholder="From"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search selhide" id="location_search">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_from_val">
                                                                    @foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
                                                                    <li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
                                                                        <div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
                                                                        <div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
                                                    </div>
                                                    <!-- .form-group end -->
                                                    <div class="form-group loc_search_field_to cus_loc_field">
                                                        <input type="hidden" id="multi_roundtosearch6" />
                                                        <input
                                                            did="s6"
                                                            ssid="6"
                                                            style="cursor: text;"
                                                            autocomplete="off"
                                                            type="text"
                                                            name="multiwaytotext6"
                                                            id="todest_show6"
                                                            class="multi_roundwayto form-control wrapper-dropdown-17"
                                                            placeholder="To"
                                                        />
                                                        <i class="fas fa-plane"></i>
                                                        <div class="location_search_to selhide" id="location_search_to">
                                                            <div class="inner_loc_search">
                                                                <div class="top_city">
                                                                    <span>Top Cities</span>
                                                                </div>
                                                                <ul class="multi_is_search_to_val">
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
                                                        <input autocomplete="off" type="text" name="brTimeStart6" value="" class="form-control" id="multipicker6" placeholder="2019/09/30" />
                                                        <i class="far fa-calendar"></i>
                                                    </div>
                                                    <!-- .form-group end -->

                                                    <a id="crs6" onclick="CloseSection('section-s6',5)" class="closem" href="javascript:;">
                                                        <i class="fas fa-times"></i>
                                                    </a>

                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="addcity" id="addAnFlt">
                                                <a class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark adm" href="javascript:;">
                                                    <i class="fas fa-plus"></i>
                                                    Add City
                                                </a>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                                <!-- .br-tabs-content end -->

                                <div class="vncbox">
                                    <ul>
                                        <li>
                                            <label class="radio-container radio-default">
                                                <input class="roundseatclass" value="2" type="radio" checked="checked" name="radio" />
                                                <span class="checkmark"></span>
                                                Economy
                                            </label>
                                        </li>
                                        <li>
                                            <label class="radio-container radio-default">
                                                <input class="roundseatclass" value="3" type="radio" name="radio" />
                                                <span class="checkmark"></span>
                                                Premium Economy
                                            </label>
                                        </li>
                                        <li>
                                            <label class="radio-container radio-default">
                                                <input class="roundseatclass" value="4" type="radio" name="radio" />
                                                <span class="checkmark"></span>
                                                Business
                                            </label>
                                        </li>
                                        <li>
                                            <label class="radio-container radio-default">
                                                <input class="roundseatclass" value="6" type="radio" name="radio" />
                                                <span class="checkmark"></span>
                                                First
                                            </label>
                                        </li>
                                        <li>
                                            <label class="label-container checkbox-default">
                                                <span>Nonstop</span>
                                                <input id="roundis_non_stop" value="1" type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>

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

<div class="container">
    <div class="flights_offers_section">
        <ul class="flights_offer_tabs">
            <li>
                <h4>Offers</h4>
            </li>
            <li class="tab_link_wrapper"><a href="javascript:void();" data-tag="one" class="activelink">All Offers</a></li>
            <li class="tab_link_wrapper"><a href="javascript:void();" data-tag="two">Flights</a></li>
            <li class="tab_link_wrapper"><a href="javascript:void();" data-tag="three">Hotels</a></li>
            <li class="tab_link_wrapper"><a href="javascript:void();" data-tag="four">Holidays</a></li>
            <li class="tab_link_wrapper"><a href="javascript:void();" data-tag="five">Cabs</a></li>
            <li class="tab_link_wrapper"><a href="javascript:void();" data-tag="six">Bank Offers</a></li>
        </ul>

        <div class="offer_tab_content">
            <div class="tab_pane" id="one">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_pane hide" id="two">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_pane hide" id="three">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_pane hide" id="four">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_pane hide" id="five">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_pane hide" id="six">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="offer_details">
                                    <div class="offerImg">
                                        <img src="https://promos.makemytrip.com/notification/xhdpi//dh-regional-116x116-12052023.jpg?im=Resize=(134,134)" alt="Offer" />
                                    </div>
                                    <div class="offerText">
                                        <span>Hotels</span>
                                        <h5>Up to 30% Off*</h5>
                                        <p>on International Hotels.</p>
                                    </div>
                                </div>
                                <div class="offerOptions">
                                    <span>T&C's Apply</span>
                                    <a href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="best_offer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="inner_best_offer">
                    <h3>Best Offers</h3>
                    <ul class="nav nav-tabs custom_tabs">
                        <li class="active"><a href="#alloffer" aria-controls="alloffer" role="tab" data-toggle="tab">All Offers</a></li>
                        <li class=""><a href="#flight" aria-controls="flight" role="tab" data-toggle="tab">Flight</a></li>
                        <!--<li class=""><a href="#hotel" aria-controls="hotel" role="tab" data-toggle="tab">Hotel</a></li>-->
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="alloffer">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
								$today = date('Y-m-d');
								$coupondetails = \App\Coupon::whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->get(); ?> @foreach($coupondetails as $coupondetail)
                                    <?php
									$image = \App\MediaImage::where('id', $coupondetail->image)->first(); ?>
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <div class="item-left">
                                                <img class="item-left-img" src="{!! asset('public/img/media_gallery/'.$image->images) !!}" alt="" />
                                            </div>
                                            <div class="item-right">
                                                <h2 class="title">{{$coupondetail->coupon_name}}</h2>
                                                <p class="desc">{{$coupondetail->shortdescription}}</p>
                                                <div class="promocode_desc">
                                                    <span class="promcde">Promocode</span>
                                                    <span class="coupncde" id="{{$coupondetail->coupon_code}}">{{$coupondetail->coupon_code}}</span>
                                                </div>
                                                <!--<a href="#" class="coupon_btn"><i class="fa fa-arrow-right"></i></a>-->
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper_button">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="flight">
                            <div class="banner_offer">
                                <img class="img-fluid" src="{!! asset('public/images/offerbanner1.jpg') !!}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="ideabox">
        <h3>Holiday Idea for you</h3>
        <div class="tb_idea">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#Familyfriendly">Family-friendly</a></li>
                <li><a data-toggle="tab" href="#Beach">Beach</a></li>
                <li><a data-toggle="tab" href="#Romantic">Romantic</a></li>
                <li><a data-toggle="tab" href="#Backpacking">Backpacking</a></li>
                <li><a data-toggle="tab" href="#Nature">Nature</a></li>
                <li><a data-toggle="tab" href="#Cultural">Cultural</a></li>
            </ul>

            <div class="tab-content">
                <div id="Familyfriendly" class="tab-pane fade in active">
                    <div class="ideaall_tb">
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/BKK.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Bangkok <span>Thailand</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>10,149</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/MCT.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Muscat <span>Oman</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>14,396</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/MLE.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>North Male Atoll <span>Maldives</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>15,826</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/AUH.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Abu Dhabi <span>United Arab Emirates</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>16,955</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/DXB.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Dubai <span>United Arab Emirates</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>17,869</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/KUL.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kuala Lumpur <span>Malaysia</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,643</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/SIN.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Singapore <span>Singapore</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>19,489</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HKG.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Hong Kong <span>China</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>22,864</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/SEL.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Seoul <span>South Korea</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>25,229</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="Beach" class="tab-pane fade">
                    <div class="ideaall_tb">
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/GOI.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Goa <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>5,790</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/CCJ.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kozhikode <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>9,064</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/MLE.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>North Male Atoll <span>Maldives</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>15,826</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/CMB.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Colombo <span>Sri Lanka</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,309</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HKT.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Phuket <span>Thailand</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>22,265</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/IST.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Istanbul <span>Turkey</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>32,081</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/SYD.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Sydney <span>Australia</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>49,797</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/CPH.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Copenhagen <span>Denmark</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>51,554</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/BCN.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Barcelona <span>Spain</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>51,554</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="Romantic" class="tab-pane fade">
                    <div class="ideaall_tb">
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/JAI.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Jaipur <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>2,590</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/GOI.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Goa <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>5,790</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/VNS.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Varanasi <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>6,080</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HJR.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Khajuraho <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>6,969</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/KTM.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kathmandu <span>Nepal</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>10,420</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/MLE.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>North Male Atoll <span>Maldives</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>15,826</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HAN.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Hanoi <span>Vietnam</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>17,094</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/BKK.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Bangkok <span>Thailand</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,392</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HKG.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Hong Kong <span>China</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>22,864</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div id="Backpacking" class="tab-pane fade">
                    <div class="ideaall_tb">
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/GOI.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Goa <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>5,790</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/KTM.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kathmandu <span>Nepal</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>10,420</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HAN.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Hanoi <span>Vietnam</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>17,094</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/DXB.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Dubai <span>United Arab Emirates</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>17,869</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/CMB.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Colombo <span>Sri Lanka</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,309</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/BKK.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Bangkok <span>Thailand</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,392</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/RGN.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Yangon <span>Myanmar</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>23,655</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/IST.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Istanbul <span>Turkey</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>32,081</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/TPE.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Taipei <span>Taiwan</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>32,708</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div id="Nature" class="tab-pane fade">
                    <div class="ideaall_tb">
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/GOI.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Goa <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>5,790</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/KTM.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kathmandu <span>Nepal</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>10,420</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/COK.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Cochin <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>10,729</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/SGN.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Ho Chi Minh City <span>Vietnam</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>16,859</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HAN.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Hanoi <span>Vietnam</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>17,094</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/CMB.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Colombo <span>Sri Lanka</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,309</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HKT.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Phuket <span>Thailand</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>22,265</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/ZRH.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Zurich <span>Switzerland</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>38,846</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/MEL.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Melbourne <span>Australia</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>45,187</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div id="Cultural" class="tab-pane fade">
                    <div class="ideaall_tb">
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/LKO.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Lucknow <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>3,556</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/VNS.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Varanasi <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>6,080</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/HYD.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Hyderabad <span>India</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>6,228</h5>
                            </div>
                        </a>
                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/KTM.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kathmandu <span>Nepal</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>10,420</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/MCT.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Muscat <span>Oman</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>14,396</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/CMB.webp') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Colombo <span>Sri Lanka</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,309</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/BKK.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Bangkok <span>Thailand</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,392</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/KUL.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Kuala Lumpur <span>Malaysia</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>18,643</h5>
                            </div>
                        </a>

                        <a href="#">
                            <div class="ideaimg">
                                <img class="img-fluid" src="{!! asset('public/images/SIN.jpg') !!}" alt="" />
                            </div>
                            <div class="textidea">
                                <h6>Singapore <span>Singapore</span></h6>

                                <span>Starting from</span>
                                <h5><i class="fa fa-rupee-sign"></i>19,489</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
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

<script>
    $(document).ready(function () {
        $(".tab_link_wrapper a").click(function () {
            $(".tab_link_wrapper a").removeClass("activelink");
            $(this).addClass("activelink");
            var tagid = $(this).data("tag");
            $(".tab_pane").removeClass("active").addClass("hide");
            $("#" + tagid)
                .addClass("active")
                .removeClass("hide");
        });
    });
</script>

@endsection
