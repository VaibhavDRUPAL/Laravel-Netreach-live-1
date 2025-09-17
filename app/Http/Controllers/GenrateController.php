<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Platform;
use App\Models\Genrate;
use URL;

class GenrateController extends Controller
{
   
   public function __construct()
    {
        $this->middleware('permission:create-vn-link-genrate');
       // $this->middleware('permission:create-permission', ['only' => ['create','store']]);
       // $this->middleware('permission:update-permission', ['only' => ['edit','update']]);
      //  $this->middleware('permission:destroy-permission', ['only' => ['destroy']]);
    }
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        activity('genrate')
            ->causedBy(Auth::user())
            ->log('view');
        $title = 'Manage Genrate';
        
        $genrate = Genrate::select('platforms.name','genrates.id','genrates.platform_id','genrates.unique_code_link','genrates.detail','genrates.tinyurl')->join('platforms', 'platforms.id', '=', 'genrates.platform_id')->where(["user_id"=>Auth::user()->id])->paginate(setting('record_per_page', 15));
        return view('genrate.index', compact('genrate','title'));
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        activity('genrate')
            ->causedBy(Auth::user())
            ->log('create');
        $title = 'Create Platform';
		
		 $genrate = Platform::pluck('name', 'id');
        return view('genrate.create', compact('title','genrate'));
    }
	
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function getTinyURL($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'unique_code_link' => 'required',
        ]);
        activity('genrate')
        ->causedBy(Auth::user()) 
        ->log('created');
        
        
		$link = Auth::user()->id."_".$request->unique_code_link;
		
        $results = Genrate::where(["user_id"=>Auth::user()->id,"platform_id"=>$request->unique_code_link])->get();;
        if($results->count() > 0){
            return redirect('genrate/create')
                        ->withErrors('App/Platform Already Created!')
                        ->withInput();
        }
        $url = Crypt::encryptString($link);	
        $useriden = md5($link);
        $vncodeWithVnCode =  URL::to("/?vncode=$useriden");

        
        $tinyurl = $this->getTinyURL($vncodeWithVnCode);
        

        Genrate::create(['platform_id'=>$request->unique_code_link,"user_identified"=>$useriden,'unique_code_link' => $url,"detail"=>$request->detail,'user_id'=>Auth::user()->id,"tinyurl"=>$tinyurl]);             
        flash('Unique Code Link created successfully!')->success();
        return redirect()->route('genrate.index');
    }
   
   
}
