<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FlightDetail extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at']; 
	
	public function flight()  
    {
        return $this->belongsTo('App\Flight','flight_id','id');
    }
	
	public function returnflight()  
    {
        return $this->belongsTo('App\Flight','ret_flight_id','id');
    }
	
	public function flightsource() 
    {
        return $this->belongsTo('App\Airport','flight_source','id');
    }
	
	public function flightdest() 
    {
        return $this->belongsTo('App\Airport','flight_destination','id');
    }
	
	public function agentdetail() 
    {
        return $this->belongsTo('App\User','agent','id');
    }
} 