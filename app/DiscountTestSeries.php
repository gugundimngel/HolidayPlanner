<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DiscountTestSeries extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'subject_numbers', 'discount', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'subject_numbers', 'created_at', 'updated_at'];
}