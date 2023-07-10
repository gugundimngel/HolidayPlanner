<?php use App\Http\Controllers\Admin\FollowupController; ?>
@if(@$totalData !== 0)
	@foreach (@$lists as $list)
		<?php $strtime = strtotime($list->created_at); ?>
		<div>
			<i class="fas fa-{{FollowupController::followuptype($list->followup_type,'icon')}} {{FollowupController::followuptype($list->followup_type,'color')}}"></i>
			<div class="timeline-item">
				<span class="time"><i class="far fa-clock"></i> <?php FollowupController::time_Ago($strtime); ?></span>
				<span class="name">{{@$list->user->first_name}} {{@$list->user->last_name}}</span>
				@if($list->followup_type == "follow_up")
					<h3 class="timeline-header"><a href="#">{{FollowupController::followuptype($list->followup_type,'name')}}</a> set for {{date('d-m-Y h:i A', strtotime($list->followup_date))}}  @if($list->rem_cat == 1) regardless @else no reply @endif     </h3>
				@else
					<h3 class="timeline-header"><a href="#">{{FollowupController::followuptype($list->followup_type,'name')}}</a></h3>
			    @endif
				@if($list->note != "")
				<h3 class="timeline-header"><a href="#">Note</a> "{{$list->note}}"</h3>
				@endif
			</div>
		</div>
	@endforeach
@else
	<div> 
		<div class="timeline-item">
			<h3 class="timeline-header">History not found</h3>
		</div>
	</div>
@endif 

<!-- 
<div>
	<i class="fas fa-comments bg-info"></i>
	<div class="timeline-item">
		<span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
		<span class="name">Suran Singh</span>
		<h3 class="timeline-header"><a href="#">Wrong Number</a></h3>
		<h3 class="timeline-header border-0"></h3>
	</div>
</div>

<div>
	<i class="fas fa-phone bg-warning"></i>
	<div class="timeline-item">
		<span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
		<span class="name">Ritesh Kumar - 8444710000</span>
		<h3 class="timeline-header"><a href="#">Call Received</a></h3>
		<div class="timeline-body">
			Received call from Punitraina38. <a href="#">Listen to call here <i class="fa fa-download"></i></a>
		</div>
	</div>
</div>

<div>
	<i class="fas fa-tag bg-info"></i>
	<div class="timeline-item">
		<span class="time"><i class="far fa-clock"></i> 27 Feb, 2020</span>
		<span class="name">Suran Singh</span>
		<div class="timeline-body">
			lead for 0 credits via Hellotravel
		</div>
	</div>
</div>bg-danger

<div> 
	<i class="fas fa-envelope bg-success"></i>
	<div class="timeline-item">
		<span class="time"><i class="far fa-clock"></i> 27 Feb, 2020</span>
		<span class="name">Ritesh Kumar - 8444710000</span>
		<h3 class="timeline-header"><a href="#">Mail Activity</a> Mail Received <i class="fa fa-share"></i></h3>
		<div class="timeline-body">
			Subject: Message from Punitraina38<br/>Hello, Please send me details<br>From: Punitraina38
		</div>
	</div>
</div>

<div>
	<i class="fas fa-tag bg-info"></i>
	<div class="timeline-item">
		<span class="time"><i class="far fa-clock"></i> 27 Feb, 2020</span>
		<span class="name">Ritesh Kumar - 8444710000</span>
		<h3 class="timeline-header"><a href="#">Assigned To</a> changed from Ritesh Kumar - 8444710000 to Suran Singh</h3>
	</div>
</div>-->