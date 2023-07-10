<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductTransactionHistory extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'student_id', 'order_id', 'product_id', 'professor_name', 'subject_name', 'mode_product', 'duration', 'validity', 'price', 'discount', 'views', 'quantity', 'total_amount', 'pay_amount', 'dispatched', 'dispatched_date', 'serial_number', 'tracking_number', 'courier_company_name', 'response', 'whole_response', 'webhook_response', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	public function student()
    {
        return $this->belongsTo('App\User','student_id');
    }
	
	public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }
	
	public function mode_product_data()
    {
        return $this->belongsTo('App\ModeProduct','mode_product');
    }
	
	public function order()
    {
        return $this->belongsTo('App\ProductOrder','order_id');
    }
}