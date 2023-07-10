<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use App\McqSubject;
use App\McqChapter;

use Auth;
use Config;

class McqChapterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
	/**
     * All Chapters.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqChapter', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= McqChapter::where('id', '!=', '')->with('subject');
		
		$totalData 	= $query->count();	//for all data
		
		//searching start	
			if ($request->has('search_term')) 
			{
				$search_term 		= 	$request->input('search_term');
				if(trim($search_term) != '')	
				{
					$query->where('chapter_name', 'LIKE', '%' . $search_term . '%');
				}
			}
			if ($request->has('search_term_subject')) 
			{
				$search_term_subject 		= 	$request->input('search_term_subject');
				if(trim($search_term_subject) != '')
				{
					$query->whereHas('subject', function ($q) use($search_term_subject){
						$q->where('subject_name', 'LIKE', '%'.$search_term_subject.'%');
					});
				}
			}
			if ($request->has('search_term_from')) 
			{
				$search_term_from 		= 	$request->input('search_term_from');
				if(trim($search_term_from) != '')
				{
					$query->whereDate('created_at', '>=', $search_term_from);
				}
			}
			if ($request->has('search_term_to')) 
			{	
				$search_term_to 		= 	$request->input('search_term_to');
				if(trim($search_term_to) != '')
				{
					$query->whereDate('created_at', '<=', $search_term_to);
				}	
			}
			
			if ($request->has('search_term') || $request->has('search_term_subject') || $request->has('search_term_from') || $request->has('search_term_to')) 
			{
				$totalData 	= $query->count();//after search
			}
		//searching end	

		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

		return view('Admin.mcq_chapters.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add MCQ Chapter.
     *
     * @return \Illuminate\Http\Response
     */
	public function addMcqChapter(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqChapter', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$subjects = McqSubject::select('id', 'subject_name')->where('status', '=', 1)->get();
		/* Get all Select Data */	
		
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();
	
			$this->validate($request, [
										'subject_id' => 'required|exists:mcq_subjects,id',
										'chapter_name' => 'required|max:255'
									  ], 
									  [
										'subject_id.exists' => 'The selected Subject is invalid.'
									  ]);

			$obj							= 	new McqChapter;
			$obj->subject_id				=	@$requestData['subject_id'];
			$obj->chapter_name				=	@$requestData['chapter_name'];
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mcq_chapters')->with('success', 'MCQ Chapter'.Config::get('constants.added'));	
			}	
		}
		return view('Admin.mcq_chapters.add_mcq_chapter', compact(['subjects']));		
	}
	
	public function editMcqChapter(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqChapter', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$subjects = McqSubject::select('id', 'subject_name')->where('status', '=', 1)->get();
		/* Get all Select Data */
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'subject_id' => 'required|exists:mcq_subjects,id',
										'chapter_name' => 'required|max:255'
									  ], 
									  [
										'subject_id.exists' => 'The selected Subject is invalid.'
									  ]);						  
									  
									  
			$obj							= 	McqChapter::find($requestData['id']);
			$obj->subject_id				=	@$requestData['subject_id'];
			$obj->chapter_name				=	@$requestData['chapter_name'];
			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mcq_chapters')->with('success', 'Chapter'.Config::get('constants.edited'));
			}		
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(McqChapter::where('id', '=', $id)->exists())
				{
					$fetchedData = McqChapter::find($id);
					return view('Admin.mcq_chapters.edit_mcq_chapter', compact(['fetchedData', 'subjects']));
				}
				else
				{
					return Redirect::to('/admin/mcq_chapters')->with('error', 'Chapter'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/mcq_chapters')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
}
