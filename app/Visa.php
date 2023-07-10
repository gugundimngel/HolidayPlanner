<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Visa extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'id',
        'visa_type',
        'country_from',
        'country_to',
        'traveler_city',
        'visa_processing',
        'descriptionTitle',
        'descriptionDetails',
        'clientsDocTitle',
        'clientsDoc_details',
        'holida_assis_title',
        'holiday_planer_Assest_details',
        'special_note_title',
        'special_note_details',
        'how_to_ApplyTitle',
        'how_to_apply_details',
        'visa_info_title',
        'visa_info_details',
        'terms_condition_title',
        'terms_condition_Details',
        'holiday_list_title',
        'holiday_list_details',
        'country_id',
        'del_status',
        'price',
        'visa_title',
        'banner_img',
        'adult_b2c_price',
        'adult_b2b_price',
        'adult_corporate_price',
        'child_b2c_price',
        'child_b2b_price',
        'child_corporate_price',
        'priceb2c',
        'Is_Popular',
        'status',
        'category_id',
        'created_at',
        'updated_at'
    ];
    
}