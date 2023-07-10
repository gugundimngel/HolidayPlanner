<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ComboProduct extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
	protected $fillable = [
		'id', 'combo_name', 'discount', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'combo_name', 'created_at', 'updated_at'];
}