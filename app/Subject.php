<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subject extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name', 'price', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'subject_name', 'price', 'created_at', 'updated_at'];
	
	public function course()
    {
        return $this->belongsTo('App\Course','which_course');
    }
	
	public function test_series_type()
    {
        return $this->belongsTo('App\TestSeriesType','which_test_series_type');
    }
	
	public function group()
    {
        return $this->belongsTo('App\Group','which_group');
    }
}