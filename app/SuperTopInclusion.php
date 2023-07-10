<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperTopInclusion extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	
	protected $fillable = [
        'id', 'name', 'image', 'created_at', 'updated_at'
    ];
  
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	public function user()
    {
        return $this->belongsTo('App\Admin','user_id','id');
    }
	public function topinclusion()
    {
        return $this->belongsTo('App\Topinclusion','id','top_inc_id');
    }
}
