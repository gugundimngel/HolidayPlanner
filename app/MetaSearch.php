<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MetaSearch extends Authenticatable 
{
    use Notifiable; 
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'destination_id', 'created_at', 'updated_at' 
    ];
   
  public $sortable = ['id', 'created_at', 'updated_at'];
 
	public function destinationdata()
    {
        return $this->belongsTo('App\Destination','destination_id','id');
    }
	
	public function mylocdata()
    {
        return $this->belongsTo('App\Location','destination_id','id');
    }
}
