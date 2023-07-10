<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use App\McqSubject;
use App\McqChapter;
use App\McqQuestion;

use Auth;
use Config;

class McqQuestionController extends Controller
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
     * All Questions.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqQuestion', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= McqQuestion::where('id', '!=', '')->with(['chapter', 'subject']);
		
		$totalData 	= $query->count();	//for all data
		
		//searching start	
			if ($request->has('search_term')) 
			{
				$search_term 		= 	$request->input('search_term');
				if(trim($search_term) != '')	
				{
					$query->where('question', 'LIKE', '%' . $search_term . '%');
				}
			}
			if ($request->has('search_term_chapter')) 
			{
				$search_term_chapter 		= 	$request->input('search_term_chapter');
				if(trim($search_term_chapter) != '')
				{
					$query->whereHas('chapter', function ($q) use($search_term_chapter){
						$q->where('chapter_name', 'LIKE', '%'.$search_term_chapter.'%');
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
			
			if ($request->has('search_term') || $request->has('search_term_chapter') || $request->has('search_term_from') || $request->has('search_term_to')) 
			{
				$totalData 	= $query->count();//after search
			}
		//searching end	

		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

		return view('Admin.mcq_questions.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add MCQ Question.
     *
     * @return \Illuminate\Http\Response
     */
	public function addMcqQuestion(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqQuestion', $request->route()->getActionMethod(), Auth::user()->role);
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
										'subject_id' => 'required',
										'which_chapter' => 'required',
										'question' => 'required',
										'option_1' => 'required',
										'option_2' => 'required',
										'option_3' => 'required',
										'option_4' => 'required',
										'answer' => 'required',
									  ]);

			$obj							= 	new McqQuestion;
			$obj->subject_id				=	@$requestData['subject_id'];
			$obj->which_chapter				=	@$requestData['which_chapter'];
			$obj->question					=	@$requestData['question'];
			$obj->option_1					=	@$requestData['option_1'];
			$obj->option_2					=	@$requestData['option_2'];
			$obj->option_3					=	@$requestData['option_3'];
			$obj->option_4					=	@$requestData['option_4'];
			$obj->answer					=	@$requestData['answer'];

			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mcq_questions')->with('success', 'MCQ Question'.Config::get('constants.added'));	
			}	
		}
		return view('Admin.mcq_questions.add_mcq_question', compact(['subjects']));		
	}
	
	public function editMcqQuestion(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqQuestion', $request->route()->getActionMethod(), Auth::user()->role);
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
										'subject_id' => 'required',
										'which_chapter' => 'required',
										'question' => 'required',
										'option_1' => 'required',
										'option_2' => 'required',
										'option_3' => 'required',
										'option_4' => 'required',
										'answer' => 'required',
									  ]);						  
			
			$obj							= 	McqQuestion::find($requestData['id']);
			$obj->subject_id				=	@$requestData['subject_id'];
			$obj->which_chapter				=	@$requestData['which_chapter'];
			$obj->question					=	@$requestData['question'];
			$obj->option_1					=	@$requestData['option_1'];
			$obj->option_2					=	@$requestData['option_2'];
			$obj->option_3					=	@$requestData['option_3'];
			$obj->option_4					=	@$requestData['option_4'];
			$obj->answer					=	@$requestData['answer'];

			$saved							=	$obj->save();							  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mcq_questions')->with('success', 'MCQ Question'.Config::get('constants.edited'));
			}		
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(McqQuestion::where('id', '=', $id)->exists())
				{
					$fetchedData = McqQuestion::find($id);
					return view('Admin.mcq_questions.edit_mcq_question', compact(['fetchedData', 'subjects']));
				}
				else
				{
					return Redirect::to('/admin/mcq_questions')->with('error', 'MCQ Question'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/mcq_questions')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function viewMcqQuestion(Request $request, $id = NULL)
	{
		if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(McqQuestion::where('id', '=', $id)->exists())
				{
					$fetchedData = McqQuestion::find($id);
					return view('Admin.mcq_questions.view_mcq_question', compact(['fetchedData', 'subjects']));
				}
				else
				{
					return Redirect::to('/admin/mcq_questions')->with('error', 'MCQ Question'.Config::get('constants.not_exist'));
				}	
			}
		else
			{
				return Redirect::to('/admin/mcq_questions')->with('error', Config::get('constants.unauthorized'));
			}	
	}
}
