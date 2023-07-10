@foreach (@$lists as $list)
	<tr id="id_{{@$list->id}}"> 
		<td>{{ @$list->flight->name == "" ? config('constants.empty') : str_limit(@$list->flight->name, '50', '...') }} {{ @$list->flight->code }} {{ @$list->flight_number }}</td>
		<td>{{ @$list->flightsource->airport_code }} ({{ @$list->flightsource->city_name }})</td> 
		  <td>{{ @$list->flightdest->airport_code }} ({{ @$list->flightdest->city_name }})</td> 
		  <td>{{ @$list->dep_time }}</td>  
		<td>{{ @$list->arival_time }}</td> 
		@if($type == 'depart' )
		<td><a dataname="{{@$list->flight->name}} {{ @$list->flight->code }} {{ @$list->flight_number }}" datacity="{{@$list->flightsource->city_name}}" datadest="{{ @$list->flightdest->city_name }}" datadepart="{{ @$list->dep_time }}" dataarival="{{ @$list->arival_time }}" dataid="{{@$list->id}}" href="javascript:;" class="btn btn-primary btn-sm selectflight">Select</a></td>
		@else
			<td><a dataname="{{@$list->flight->name}} {{ @$list->flight->code }} {{ @$list->flight_number }}" datacity="{{@$list->flightsource->city_name}}" datadest="{{ @$list->flightdest->city_name }}" datadepart="{{ @$list->dep_time }}" dataarival="{{ @$list->arival_time }}" dataid="{{@$list->id}}" href="javascript:;" class="btn btn-primary btn-sm retselectflight">Select</a></td>
		@endif
	</tr>
@endforeach