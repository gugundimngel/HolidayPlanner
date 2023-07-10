<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PackageGallery extends Authenticatable
{
    use Notifiable; 
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'package_id', 'package_gallery_image_alt', 'package_gallery_image', 'created_at', 'updated_at' 
    ];
   
  public $sortable = ['id', 'created_at', 'updated_at'];
 
	
	public function galleriesmedia()
    {
        return $this->belongsTo('App\MediaImage','package_gallery_image','id');
    }
}
