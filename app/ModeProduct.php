<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ModeProduct extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'mode_product', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'mode_product', 'created_at', 'updated_at'];
}