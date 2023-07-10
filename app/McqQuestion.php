<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class McqQuestion extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'subject_id', 'which_chapter', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'question', 'created_at', 'updated_at'];

	public function subject()
    {
        return $this->belongsTo('App\McqSubject','subject_id');
    }
	
	public function chapter()
    {
        return $this->belongsTo('App\McqChapter','which_chapter');
    }
}