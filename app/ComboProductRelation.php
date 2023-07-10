<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ComboProductRelation extends Authenticatable
{
    use Notifiable;
	
	protected $fillable = [
		'id', 'combo_id', 'product_id', 'created_at', 'updated_at'
    ];
}