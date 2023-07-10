<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TestSeriesLog extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'zip_name', 'zip_size', 'start_from', 'end_to', 'is_deleted', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'created_at', 'updated_at'];
}