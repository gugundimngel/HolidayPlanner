<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductOrder extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
	protected $fillable = [
        'id', 'student_id', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	public function student()
    {
        return $this->belongsTo('App\User','student_id');
    }
	
	public function product_transaction_history()
    {
        return $this->hasMany('App\ProductTransactionHistory','order_id');
    }
	
}