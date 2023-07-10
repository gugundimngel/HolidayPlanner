<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ScheduledTest extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'student_id', 'test_id', 'test_data', 'scheduled_date', 'test_submitted', 'test_submitted_copy', 'submit_date', 'test_reviewed', 'test_reviewed_copy', 'reviewed_date', 'marks', 'additional_remarks', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'scheduled_date', 'submit_date'];
	
	public function student()
    {
        return $this->belongsTo('App\User','student_id');
    }
	
	public function test()
    {
        return $this->belongsTo('App\Test','test_id');
    }
}