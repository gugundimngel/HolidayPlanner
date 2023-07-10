<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Destination extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'dest_type', 'dest_name', 'description', 'image_alt', 'image', 'tour_policy', 'is_active',  'created_at', 'updated_at'
    ];
  
	public $sortable = ['id', 'created_at', 'updated_at'];
 
	public function user() 
    {
        return $this->belongsTo('App\Admin','user_id','id');
    }
	
	public function desmedia() 
    {
        return $this->belongsTo('App\MediaImage','dest_image','id');
    }
	
	public function mypackage() 
    {
        return $this->hasMany('App\Package','destination','dest_id');
    }
	
	public function myloc() 
    {
        return $this->belongsTo('App\Location','dest_id','id');
    }
} 
