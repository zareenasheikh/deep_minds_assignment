<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\user_category;

class user_expense extends Model
{
     protected $fillable = [
     	
'expense_amount',
'category_id',
'expense_date',
'user_id',

	 ];

	  public function category(){
        return $this->belongsTo(user_category::class);
    }


}
		

 // php artisan make:migration create_user_expenses_table --create=user_expenses