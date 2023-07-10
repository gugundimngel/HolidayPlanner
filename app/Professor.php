<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Professor extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	protected $fillable = [
        'id', 'organisation_role', 'which_organisation', 'first_name', 'last_name', 'mobile', 'gstin', 'about_faculty', 'date_of_agreement', 'assistant_name', 'assistant_number', 'order_number', 'org_professor_image', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'first_name', 'last_name', 'email', 'order_number', 'created_at', 'updated_at'];
	
	public function organisationData()
    {
        return $this->belongsTo('App\Admin','which_organisation');
    }
	
	public function productData()
    {
        return $this->hasMany('App\Product','professor_id');
    }
}
