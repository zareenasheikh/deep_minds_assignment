<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\user_category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;


class category_masterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    { 
        $this->middleware('auth');
        
    }

    
    public function index()
    {
        $records=user_category::orderBy('id','desc');

        if (!empty($request->search)) {
         $records= $records
         ->orWhere('category_name','like','%' . $request->search . '%')
         ->orWhere('category_icon','like','%' . $request->search . '%');
     }

     $records= $records
     ->where('user_id',Auth::user()->id)
     ->select('id','category_name','category_icon')

     ->paginate(25);



     return view('frontend.category.index',compact('records'));
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('frontend.category.create');
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = array(
        'category_name'=>$request->input('category_name'),
        'category_icon'=>$request->input('category_icon'),
        'user_id'=>Auth::user()->id,
    );
       $user_category = new user_category($data);
       $user_category->save();



       $notification = array(
        'message' => 'Your form was successfully submit!', 
        'alert-type' => 'success'
    );

       return Redirect::to('category')->with($notification);
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('frontend.category.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $record = user_category::find($id);         

       return view('frontend.category.edit',compact('record'));
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category_update(Request $request)
    {
       $user_category = user_category::find($request->id); 

       $data = array(
          'category_name'=>$request->input('category_name'),
          'category_icon'=>$request->input('category_icon'),

      );
       $user_category->update($data);





       $notification = array(
        'message' => 'Your form was successfully Update!', 
        'alert-type' => 'success'
    );

       return Redirect::to('category')->with($notification);
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
     $user_category = user_category::find($request->id);
     $user_category->delete();

     return $user_category;
 }
}
