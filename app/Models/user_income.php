<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_income extends Model
{
     protected $fillable = [
'date',
'amount',
'user_id'

	 ];
}
		

 // php artisan make:migration create_user_incomes_table --create=user_incomes