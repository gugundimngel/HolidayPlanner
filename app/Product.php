<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use Notifiable;
	use Sortable;
	
	protected $fillable = [
		'id', 'professor_id', 'subject_name', 'course_level', 'attempt_info', 'package', 'video_language', 'study_material_language', 'dispatched_by', 'delivery_period', 'system_requirement', 'runs_on', 'batch_type', 'feature_product', 'features', 'no_lecture', 'syllabus_coverage', 'amendment', 'faculty_support', 'lecture_recorded', 'fast_forward', 'books_provided', 'index_order', 'other_info', 'validity_start_from', 'validity_extension', 'views_extension', 'internet_connectivity', 'dispatch_time', 'stock_out', 'order_number', 'sampleImage', 'image', 'status', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'subject_name', 'order_number', 'created_at', 'updated_at'];
	
	public function professor()
    {
        return $this->belongsTo('App\Professor','professor_id');
    }
	
	public function productOtherInfo()
    {
        return $this->hasMany('App\ProductOtherInformation','product_id');
    }
}