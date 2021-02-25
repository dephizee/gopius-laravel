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

    public function course()
    {
        // belongsTo(RelatedModel, foreignKey = course_id, keyOnRelatedModel = id)
        return $this->belongsTo(Course::class, 'course_no', 'course_id');
    }

    /**
     * Assignment belongs to Instructor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor()
    {
        // belongsTo(RelatedModel, foreignKey = instructor_id, keyOnRelatedModel = id)
        return $this->belongsTo(Instructor::class, 'instr_no', 'instr_id');
    }
}
