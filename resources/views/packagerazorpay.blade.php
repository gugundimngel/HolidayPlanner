@extends('layouts.frontend')
@section('pagespecificstyles')

@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Error!</strong> {{ $message }}
                </div>
            @endif
            {!! Session::forget('error') !!}
            @if($message = Session::get('success'))
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif
            {!! Session::forget('success') !!}
            <div class="panel panel-default">
                <div class="panel-heading">Pay With Razorpay</div>
<?php
$rzkey = \App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value;
$set = \App\Admin::where('id',1)->first();
?>
                <div class="panel-body text-center">
                    <form action="{!!route('userpackagepaywithrazorpay')!!}" method="POST" >
                        <!-- Note that the amount is in paise = 50 INR -->
                        <!--amount need to be in paisa-->
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="rzp_test_9BsnxNsU16jr90"
                                data-amount="{{round($finaltotal) * 100}}"
                                data-buttontext="Pay {{round($finaltotal)}} INR"
                                data-name="Book Flight"
                                data-description="Order Value"
                                data-image="{{URL::to('/public/img/profile_imgs')}}/{{@$set->logo}}"
                                data-prefill.name="{{@$name}}"
                                data-prefill.email="{{@$email}}"
                                data-theme.color="#ff7529">
                        </script>
                        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($){
	$('.razorpay-payment-button').on('click', function(){
		$('.showload').show();
	});
});
</script>
@endsection