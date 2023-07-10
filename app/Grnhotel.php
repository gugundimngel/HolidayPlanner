<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Grnhotel extends Authenticatable
{
	protected $connection = 'mysql2';
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
		
	protected $fillable = [
        'id',  'created_at', 'updated_at'
    ];
  
	public $sortable = ['id', 'created_at', 'updated_at'];
 
	 public function hotelimages() {
         return $this->belongsTo('App\HotelImage','hotel_code','hotel_code');
    }

    // results in a "problem", se examples below
    public function available_images() {
        return $this->hotelimages()->where('main_image','=', 'Y');
    }
	
	 public function hotelfac() {
        return $this->hasMany('App\GrnHotelFac','hotel_code','hotel_code');
    }
	
	public function hotelmainimages() {
        return $this->hasMany('App\HotelImage','hotel_code','hotel_code');
    }
	  public function hotelcities() {
		 
       return $this->belongsTo('App\HotelCity','city_code','city_code');
    } 
}
