<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductOtherInformation extends Authenticatable
{
    use Notifiable;
	
	protected $fillable = [
		'id', 'product_id', 'mode_of_product', 'duration', 'validity', 'price', 'discount', 'views', 'total_amount', 'created_at', 'updated_at'
    ];
	
	public function mode_product()
    {
        return $this->belongsTo('App\ModeProduct','mode_of_product');
    }
}