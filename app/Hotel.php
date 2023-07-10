<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Hotel extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id','name', 'dest_type', 'destination','hotel_category', 'image_alt', 'image','hotel_gallery', 'description', 'amenities', 'help_line_no', 'email', 'address', 'pin_code', 'status',  'created_at', 'updated_at'
    ];
  
	public $sortable = ['id', 'created_at', 'updated_at'];
 
	public function user()
    {
        return $this->belongsTo('App\Admin','user_id','id');
    }
	
	public function destinations()
    {
        return $this->belongsTo('App\Destination','destination','id');
    }
	public function locations()
    {
        return $this->belongsTo('App\Location','destination','id');
    }
}
