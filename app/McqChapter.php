<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class McqChapter extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'subject_id', 'chapter_name', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'chapter_name', 'created_at', 'updated_at'];

	public function subject()
    {
        return $this->belongsTo('App\McqSubject','subject_id');
    }
	
}