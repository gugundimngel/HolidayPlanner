<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PackagePrice extends Authenticatable
{
    use Notifiable; 
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'package_id', 'created_at', 'updated_at' 
    ];
   
  public $sortable = ['id', 'created_at', 'updated_at'];
 
}
