<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class McqSubject extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'subject_name', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'subject_name', 'created_at', 'updated_at'];
}