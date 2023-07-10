<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MyCart extends Authenticatable
{
    use Notifiable;

	protected $fillable = [
        'id', 'user_id', 'is_expired', 'created_at', 'updated_at'
    ];
	
	public function cartItem()
    {
        return $this->hasMany('App\CartItem','cart_id');
    }
	
}