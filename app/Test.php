<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Test extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
		'id', 'test_number', 'test_name', 'which_subject', 'from_date', 'to_date', 'estimated_time', 'marks', 'test_pdf', 'test_suggestion_pdf', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'test_name', 'created_at', 'updated_at'];
	
	public function subject()
    {
        return $this->belongsTo('App\Subject','which_subject');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Admin','which_vendor');
    }
	
	public function scheduledTest()
    {
        return $this->hasMany('App\ScheduledTest','test_id');
    }
}