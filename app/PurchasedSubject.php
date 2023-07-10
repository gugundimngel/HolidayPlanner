<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PurchasedSubject extends Authenticatable
{
    use Notifiable;

	protected $fillable = [
        'id', 'student_id', 'subject_id', 'subject_data', 'test_series_transaction_id', 'status', 'created_at', 'updated_at'
    ];
	
	public function student()
    {
        return $this->belongsTo('App\User','student_id');
    }
	
	public function subject()
    {
        return $this->belongsTo('App\Subject','subject_id');
    }
}