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
use App\Models\user_income;
use Calendar;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = User::find(1);
        Auth::login($user);



        $expenses_records=user_expense::where('user_id',\Auth::user()->id)
        ->limit(4)
        ->get();

        $total_income_amount=user_income::where('user_id',\Auth::user()->id)
        ->sum('amount');



        $total_expense_amount=user_expense::where('user_id',\Auth::user()->id)
        ->sum('expense_amount');



        $total_balance_amount=$total_income_amount-$total_expense_amount;


        $user_categories = DB::table('user_categories')  
        ->select('category_name','id')
        ->orderBy('id', 'asc')->pluck('category_name','id'); 



        $events = [];
        $data = user_expense::where('user_id',\Auth::user()->id)->get();
        if($data->count()) {
            foreach ($data as $key => $value) {

              
              $colors= [
                'color' => '#57c574',
                        // 'url' => url('admins/vendor_booking/'.$value->id),
            ];
            

            
            $events[] = Calendar::event(
                $value->category->category_name.' Rs '.$value->expense_amount,
                true,
                new \DateTime($value->expense_date),
                new \DateTime($value->expense_date.' +1 day'),
                null,
                    // Add color and link on event
                $colors
                    // [
                    //     'color' => '#f05050',
                    //     'url' => url('admins/vendor_booking'),
                    // ]

            );
        }
    }

    $calendar=[];
    $calendar = Calendar::addEvents($events);


// dd($calendar);

                // $data = user_expense::where('user_id',\Auth::user()->id)->whereRaw('MONTH(created_at) = '.$month)->get();

    $bulks = user_expense::select(
        DB::raw('sum(expense_amount) as sums'), 
        DB::raw("DATE_FORMAT(expense_date,'%M') as months")


    )
    ->groupBy('months')
    ->pluck('months','sums')->toArray();

// dd($bulks);


    $month=["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];

    $arrays=[];

    foreach($month as $vall){

// dd($vall);
        if (in_array($vall, $bulks))
        {
            
           $arrays[]=array_search($vall,$bulks);;
       }
       else
       {
           $arrays[]=0;
       }


   }

  // return JSON.parse($arrays);

   return view('frontend.home',compact('expenses_records','user_categories','total_income_amount','total_expense_amount','total_balance_amount','calendar','bulks','arrays'));
}





}
