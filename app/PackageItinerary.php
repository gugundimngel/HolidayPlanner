<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PackageItinerary extends Authenticatable
{
    use Notifiable; 
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'package_id', 'title', 'details', 'itinerary_image', 'foodtype', 'created_at', 'updated_at' 
    ];
   
  public $sortable = ['id', 'created_at', 'updated_at'];
 
 
	public function itsmedia()
    {
        return $this->belongsTo('App\MediaImage','itinerary_image','id');
    }
	
}
