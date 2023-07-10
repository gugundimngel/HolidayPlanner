<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductReview extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'user_id', 'product_id', 'review', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	public function studentData()
    {
        return $this->belongsTo('App\User','user_id');
    }
	
	public function productData()
    {
        return $this->belongsTo('App\Product','product_id');
    }
}