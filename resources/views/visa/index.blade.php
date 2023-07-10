
@extends('layouts.frontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', @$seoDetails->meta_title)
@section('meta_keyword', @$seoDetails->meta_keyword)
@section('meta_description', @$seoDetails->meta_desc)
@section('bodyclass', 'homepage')
@section('pagespecificstyles')

@endsection
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css ">
    
    
    <style>
        .visaBanner {
            position: relative;
            background: #135ea0;
            background-size: cover;
            background-position: center;
            min-height: 350px;
            display: flex;
            align-items: center;
        }

        /*.visaBanner:before {*/
        /*    content: "";*/
        /*    height: 100%;*/
        /*    width: 100%;*/
        /*    position: absolute;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    background: #0000001f;*/
        /*}*/

        .searchForm {
            position: relative;
        }

        .searchForm .form-control {
            height: 60px;
            font-size: 16px;
            font-weight: 600;
        }

        .searchBtn {
            padding: 17px 35px;
            border: none;
            font-size: 18px;
            font-weight: 600;
            background-color: #f86638;
            color: #fff;
            border-radius: 4px;
        }
        
        .form_flex_row{
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .form_flex_row .input_wrapper {
            width: 22.2%;
        }
        
        .visa_cards_Section {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        
        .visa_cards_Section .card {
            border-radius: 10px;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
        
        .visa_cards_Section .cardImg {
            overflow: hidden;
            height: 200px;
            border-radius: 10px 10px 0 0;
        }
        
        .visa_cards_Section .cardImg img {
            width: 100%;
            height: auto;
            transition: 1s all ease;
        }        
        
        .visa_cards_Section .cardImg img:hover {
            scale: 1.2;
        }
        
        .visa_cards_Section .card_details {
            padding: 15px;
        }

        .visa_cards_Section .card_details .enquiryBtn {
            padding: 8px 14px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            background-color: #f86638;
            color: #fff;
            display: block;
            width: fit-content;
            border-radius: 3px;
        }
        
        .visa_cards_Section .flexBox {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 25px;
        }

        .visa_cards_Section .flexBox p {
            margin-bottom: 0;
            font-size: 13px;
        }
        
        .visa_cards_Section .row {
            margin-top: 40px;
        }
        
        .starRatings i {
            font-size: 12px;
            color: #f86638;
        }
        
        .visa_cards_Section .card{
            margin-bottom: 25px;
        }
        
        @media(max-width: 991px){
            .visaBanner {
                padding-top: 80px;
            }
            
            .form_flex_row {
                flex-wrap: wrap;
                gap: 20px;
            }
            
            .form_flex_row .input_wrapper {
                width: 48%;
            }
            
            .visaBanner {
                padding-top: 80px;
            }
            
            .searchBtn {
                width: 100%;
            }
            
            .submit_action {
                width: 100%;
            }
            
        }
        
        @media(max-width:530px){
            .form_flex_row .input_wrapper {
                width: 100%;
            }
            
            .visaBanner {
                padding-bottom: 50px;
            }
            
            .searchBtn {
                padding: 14px;
            }
        }
        
        
    </style>


</head>

<body>

    <div class="visaBanner">
        <div class="container">
            <div class="searchForm">
                <form action="{{ url('/visa/search') }}" method="post">
                    @csrf
                    <div class="form_flex_row">
                        <div class="input_wrapper">
                            <div class="form-group">
                                <select class="form-select form-control" name="visa_for" id="">
                                    <option value="" selected disabled>Visa For</option>
                                    @if($country)
                                    @foreach($country as $count)
                                    <option value="{{$count->id}} ">{{$count->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="input_wrapper">
                            <div class="form-group">
                                <select class="form-select form-control" name="narionality" id="">
                                    <option value="" selected disabled>Select Nationality</option>
                                    @if($country)
                                    @foreach($country as $count)
                                    <option value="{{$count->id}} ">{{$count->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="input_wrapper">
                            <div class="form-group">
                                <select class="form-select form-control" name="livinf_Select" id="">
                                    <option value="" selected disabled>Select Living</option>
                                   @if($country)
                                    @foreach($country as $count)
                                    <option value="{{$count->id}} ">{{$count->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="input_wrapper">
                            <input class="form-control" id="datepicker-time-start-visa" type="text">
                        </div>

                        <div class="submit_action">
                            <button type="submit" class="searchBtn">Search</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container visa_cards_Section">
        <h4>Apply Hassle Free E-visas</h4>
        <p class="subheading">Hassle-Free travel with E-Visa: Your international gateway awaits!</p>
            
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/ugandavisa.jpg')}}" alt="Uganda Visa">
                    </div>
                    <div class="card_details">
                      <a href="/visa/details" class="">  <h5>Uganda Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/dubaivisa.jpg')}}" alt="Dubai Visa">
                    </div>
                    <div class="card_details">
<a href="/visa/details" class=""><h5>Dubai Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/indonesiavisa.jpg') }}" alt="Indonesia Visa">
                    </div>
                    <div class="card_details">
<a href="/visa/details" class=""><h5>Indonesia Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/bahrainvisa.jpg') }}" alt="Bahrain Visa">
                    </div>
                    <div class="card_details">
<a href="/visa/details" class=""><h5>Bahrain Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="container visa_cards_Section">
        <h4>International Tourist Visas for UAE</h4>
        <p class="subheading">Don't let visa worries hold you back from travelling - Get International Tourist Visa now </p>
            
        <div class="row">
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/dubaivisa.jpg') }}" alt="Dubai Visa">
                    </div>
                    <div class="card_details">
                      <a href="/visa/details" class="">  <h5>Dubai Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/bahrainvisa.jpg') }}" alt="Bahrain Visa">
                    </div>
                    <div class="card_details">
                     <a href="/visa/details" class="">   <h5>Bahrain Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/indonesiavisa.jpg')}}" alt="Indonesia Visa">
                    </div>
                    <div class="card_details">
                       <a href="/visa/details" class=""> <h5>Indonesia Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/ugandavisa.jpg') }}" alt="Uganda Visa">
                    </div>
                    <div class="card_details">
                      <a href="/visa/details" class="">  <h5>Uganda Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/ugandavisa.jpg')}}" alt="Uganda Visa">
                    </div>
                    <div class="card_details">
<a href="/visa/details" class=""><h5>Uganda Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/bahrainvisa.jpg')}}" alt="Bahrain Visa">
                    </div>
                    <div class="card_details">
                      <a href="/visa/details" class="">  <h5>Bahrain Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/dubaivisa.jpg')}}" alt="Dubai Visa">
                    </div>
                    <div class="card_details">
                      <a href="/visa/details" class="">  <h5>Dubai Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="cardImg">
                        <img src="{{URL::to('/public/images/visa/indonesiavisa.jpg')}}" alt="Indonesia Visa">
                    </div>
                    <div class="card_details">
                      <a href="/visa/details">  <h5>Indonesia Visa</h5></a>
                        <div class="flexBox">
                            <div>
                                <p>5 Reviews</p>
                                <span class="starRatings">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </div>
                            <a href="/visa/details" class="enquiryBtn">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

@endsection
@section('scripts')
<script>
	
                $(document).ready(function() {
                    var dateToday = new Date();
    var dates = $("#datepicker-time-start-visa").datepicker({
		defaultDate: "+2d",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: 'yy/mm/dd',
		minDate: dateToday,
		onSelect: function (selectedDate) {
		
			var option = this.id == "datepicker-time-start" ? "minDate" : "maxDate",
				instance = $(this).data("datepicker"),
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker("option", option, date);
			
		}  /* beforeShowDay: function(date) {
      var selectable = true;
      var classname = "";
      var title = "" + dayrates[date.getDay()];
      return [selectable, classname, title];
    } */
	});
	});
</script>

@endsection