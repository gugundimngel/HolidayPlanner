<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CartItem extends Authenticatable
{
    use Notifiable;

	protected $fillable = [
        'id', 'cart_id', 'user_id', 'product_id', 'product_other_info_id', 'quantity', 'created_at', 'updated_at'
    ];
	
	public function productData()
    {
        return $this->belongsTo('App\Product','product_id');
    }
	
	public function productOtherInfo()
    {
        return $this->belongsTo('App\ProductOtherInformation','product_other_info_id');
    }
	
	
}