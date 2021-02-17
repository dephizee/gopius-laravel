<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $primaryKey = "quiz_id";

    protected $fillable = [
    	'quiz_title',
    	'start_date',
    	'end_date',
    	'course_no',
    	'instr_no',
    	'duration',
    ];

    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Quiz belongs to Course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        // belongsTo(RelatedModel, foreignKey = course_id, keyOnRelatedModel = id)
        return $this->belongsTo(Course::class, 'course_no', 'course_id');
    }
}
