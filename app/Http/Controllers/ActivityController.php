<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    function activity(Request $request){
        
		$infos = DB::table('activities')->orderBy('id', 'desc')->where('uid',Auth()->user()->id)->paginate(10);
		
		$pages = range(1, $infos->lastPage());
        
        if($request->role == 'admin'){
            return view('admin.activities',compact('infos','pages'));
        }
        
        return view('user.activities',compact('infos','pages'));
	}
	
    function delete(Request $request){
        
		if(isset($request->ids)){
            
			DB::table('activities')
			->whereIn('id',$request->ids)
			->where('uid',Auth()->user()->id)
			->delete();
		}else{
            
			DB::table('activities')
			->where('id',$request->id)
			->where('uid',Auth()->user()->id)
			->delete();
		}
	}
}
