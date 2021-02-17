<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    use HasFactory;

    protected $primaryKey = "quiz_option_id";

    protected $fillable = [
    	'quiz_option_title',
    	'is_correct',
    	'quiz_question_no',
    ];
}
