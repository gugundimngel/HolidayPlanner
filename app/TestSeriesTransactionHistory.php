<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TestSeriesTransactionHistory extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'student_id', 'transaction_id', 'total_amount', 'discount', 'pay_amount', 'response', 'whole_response', 'webhook_response', 'status', 'session_finish', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
	
	public function student()
    {
        return $this->belongsTo('App\User','student_id');
    }
	
	public function purchased_subject()
    {
        return $this->hasMany('App\PurchasedSubject','test_series_transaction_id');
    }
}