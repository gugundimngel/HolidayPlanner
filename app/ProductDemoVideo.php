<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductDemoVideo extends Authenticatable
{
    use Notifiable;
	
	protected $fillable = [
		'id', 'product_id', 'demo_videos', 'created_at', 'updated_at'
    ];
}