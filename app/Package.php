<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Package extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'type', 'destination', 'package_name', 'package_image_alt', 'package_image', 'package_overview', 'package_validity', 'no_of_nights', 'details_day_night', 'no_of_days', 'support_no',	'sales_price', 'offer_price', 'discount', 	'price_details', 'price_summary', 'package_inclusions', 'package_topinclusions', 'package_exclusions', 'package_tourpolicy', 'pdf', 'meta_search', 'status', 'created_at', 'updated_at'
    ];  
  
	public $sortable = ['id', 'created_at', 'sort_order', 'updated_at'];
 
	public function user()
    {
        return $this->belongsTo('App\Admin','user_id','id');
    }
	 
	public function media()
    {
        return $this->belongsTo('App\MediaImage','package_image','id');
    }
	
	public function bamedia()
    {
        return $this->belongsTo('App\MediaImage','banner_image_m','id');
    }
	
	public function packitinerary()
    { 
        return $this->hasMany('App\PackageItinerary','package_id','id')->orderBy('id','ASC');
    }
	
	public function packtheme()
    { 
        return $this->belongsTo('App\PackageTheme','id','package_id');
    }
	
	public function packigalleries()
    {
        return $this->hasMany('App\PackageGallery','package_id','id')->orderBy('id','ASC');
    }
	
	public function packhotel()
    { 
        return $this->hasMany('App\PackageHotel','package_id','id')->orderBy('id','ASC');
    }
	public function packloc()
    { 
        return $this->belongsTo('App\Location','destination','id');
    }

}
