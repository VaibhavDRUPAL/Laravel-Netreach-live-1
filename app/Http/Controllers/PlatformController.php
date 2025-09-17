<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Platform;

class PlatformController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-app-platform');
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
        activity('platform')
            ->causedBy(Auth::user())
            ->log('view');
        $title = 'Manage Platform';
        $platform = Platform::paginate(setting('record_per_page', 15));
        return view('platform.index', compact('platform','title'));
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        activity('platform')
            ->causedBy(Auth::user())
            ->log('create');
        $title = 'Create Platform';
        return view('platform.create', compact('title'));
    }
	
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:platforms|max:255',
        ]);
        activity('platform')
        ->causedBy(Auth::user()) 
        ->log('created');
        
				
        Platform::create(['name' => $request->name]);           
  
        flash('Platform created successfully!')->success();
        return redirect()->route('platform.index');
    }
}
