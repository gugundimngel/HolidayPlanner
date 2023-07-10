<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PackageTheme extends Authenticatable
{
    use Notifiable; 
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'package_id', 'holiday_type', 'created_at', 'updated_at' 
    ];
   
  public $sortable = ['id', 'created_at', 'updated_at'];
 
	public function holidaytype()
    {
        return $this->belongsTo('App\Holidaytype','holiday_type','id');
    }
	
	public function holidaypackage()
    {
        return $this->hasMany('App\Package','package_id','id');
    }
}
