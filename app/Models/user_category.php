<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_category extends Model
{
     protected $fillable = [

'category_name',
'category_icon',
'user_id',
	 ];
}
		

 // php artisan make:migration create_user_categories_table --create=user_categories