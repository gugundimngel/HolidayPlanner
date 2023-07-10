<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TestSeriesType extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'test_series_type', 'description', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'test_series_type', 'created_at', 'updated_at'];
}