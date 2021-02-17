<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $primaryKey = "ass_id";

    protected $fillable = [
    	'ass_title',
    	'ass_content',
    	'end_date',
    	'course_no',
    	'instr_no',
    ];

    
    protected $casts = [
        'end_date' => 'datetime',
    ];
}
