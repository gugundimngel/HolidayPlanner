<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Addon extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	
	public function destinations()
    {
        return $this->belongsTo('App\Destination','destination','id');
    }
	public function locations()
    {
        return $this->belongsTo('App\Location','destination','id');
    }
}