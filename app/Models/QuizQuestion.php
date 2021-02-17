<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $primaryKey = "quiz_question_id";

    protected $fillable = [
    	'quiz_question_title',
    	'type',
    	'multiple_select',
    	'quiz_no',
    ];
}
