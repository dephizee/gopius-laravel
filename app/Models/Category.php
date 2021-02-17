<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = "cat_id";

    protected $fillable = [
    	'cat_title',
    	'cat_desc',
    	'cat_code',
    	'cat_max_student',
    	'cat_status',
    	'org_no',
    ];
}
