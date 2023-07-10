<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MediaImage extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
	protected $fillable = [
        'id', 'images', 'created_at', 'updated_at'
    ];
}