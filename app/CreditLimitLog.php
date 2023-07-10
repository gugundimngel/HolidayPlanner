<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CreditLimitLog extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'agent_id', 'credit_limit', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'agent_id', 'created_at', 'updated_at'];
}