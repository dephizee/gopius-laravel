<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $primaryKey = "poll_id";

    protected $fillable = [
    	'poll_title',
    	'end_date',
    	'cat_no',
    	'instr_no',
    ];

    /**
     * Poll belongs to Instructor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor()
    {
    	// belongsTo(RelatedModel, foreignKey = instructor_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Instructor::class, 'instr_no', 'instr_id');
    }

    /**
     * Poll has many PollOptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = poll_id, localKey = id)
    	return $this->hasMany(PollOption::class, 'poll_no', 'poll_id' );
    }

    /**
     * Poll belongs to Class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class()
    {
    	// belongsTo(RelatedModel, foreignKey = class_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Category::class, 'cat_no', 'cat_id');
    }
}
