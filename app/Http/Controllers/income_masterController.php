<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\user_income;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;


class income_masterController extends Controller
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

     $records=user_income::orderBy('id','desc');

     if (!empty($request->search)) {
         $records= $records
         ->orWhere('date','like','%' . $request->search . '%')
         ->orWhere('amount','like','%' . $request->search . '%')
         ->orWhere('user_id','like','%' . $request->search . '%');
     }

     $records= $records
     ->where('user_id',Auth::user()->id)
     ->select('id','date','amount')
     ->paginate(25);



     return view('frontend.income.index',compact('records'));
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('frontend.income.create');
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
       'date'=>$request->input('date'),
       'amount'=>$request->input('amount'),
       'user_id'=>Auth::user()->id,
   );
     $user_income = new user_income($data);
     $user_income->save();



     $notification = array(
        'message' => 'Your form was successfully submit!', 
        'alert-type' => 'success'
    );



     return Redirect::to('income')->with($notification);
 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('frontend.income.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $record = user_income::find($id);         

      return view('frontend.income.edit',compact('record'));

  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function income_update(Request $request)
    {

        $user_income = user_income::find($request->id); 

        $data = array(
            'date'=>$request->input('date'),
            'amount'=>$request->input('amount'),
            'user_id'=>Auth::user()->id,

        );
        $user_income->update($data);





        $notification = array(
            'message' => 'Your form was successfully Update!', 
            'alert-type' => 'success'
        );

        return Redirect::to('income')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
     $user_income = user_income::find($request->id);
     $user_income->delete();

     return $user_income;
 }
}
