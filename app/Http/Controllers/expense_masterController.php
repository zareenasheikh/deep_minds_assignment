<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\user_expense;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class expense_masterController extends Controller
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
        $records=user_expense::orderBy('id','desc');

        if (!empty($request->search)) {
         $records= $records
         ->orWhere('expense_amount','like','%' . $request->search . '%')
         ->orWhere('expense_date','like','%' . $request->search . '%')
         ->orWhere('category_id','like','%' . $request->search . '%');
     }

     $records= $records
     ->where('user_id',Auth::user()->id)

     ->paginate(25);



     return view('frontend.expense.index',compact('records'));
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('frontend.expense.create');
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
        'expense_amount'=>$request->input('expense_amount'),
        'category_id'=>$request->input('category_id'),
        'user_id'=>Auth::user()->id,
        'expense_date'=>$request->input('expense_date'),

    );
     $user_expense = new user_expense($data);
     $user_expense->save();



     $notification = array(
        'message' => 'Your form was successfully submit!', 
        'alert-type' => 'success'
    );

     return Redirect::back()->with($notification);
 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return view('frontend.expense.show');
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $record = user_expense::find($id);         

      return view('frontend.expense.edit',compact('record'));
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $user_expense = user_expense::find($id); 

       $data = array(
          'expense_amount'=>$request->input('expense_amount'),
          'category_id'=>$request->input('category_id'),
          'expense_date'=>$request->input('expense_date'),

      );
       $user_expense->update($data);





       $notification = array(
        'message' => 'Your form was successfully Update!', 
        'alert-type' => 'success'
    );

       return Redirect::back()->with($notification);
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $user_expense = user_expense::find($request->id);
       $user_expense->delete();

       return $user_expense;
   }
}
