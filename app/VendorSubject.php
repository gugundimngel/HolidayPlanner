<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class VendorSubject extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
	protected $fillable = [
		'vendor_id', 'subject_id', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	public function subject()
    {
        return $this->belongsTo('App\Subject','subject_id');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Admin','vendor_id');
    }
}