<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BookingDetail extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'created_at', 'updated_at'
    ];
  
	public $sortable = ['id', 'created_at', 'updated_at'];
 
	public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
	public function agent()
    {
        return $this->belongsTo('App\Agent','user_id','id');
    }
	public function paymentdetail()
    {
        return $this->belongsTo('App\PaymentDetail','id','bookingid');
    }
}
