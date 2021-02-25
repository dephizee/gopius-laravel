<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Block extends Model
{
    use HasFactory;
    protected $primaryKey = "block_id";

    protected $fillable = [
    	'block_title',
    	'chapter_no',
    ];


    /**
     * Block has many BlockLearner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blockLearner()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = block_id, localKey = id)
    	return $this->hasMany(BlockLearner::class, 'block_no', 'block_id')->where('learner_no', Auth::guard('learner')->user()->learner_id);
    }

    // public function viewed()
    // {
    // 	// hasMany(RelatedModel, foreignKeyOnRelatedModel = block_id, localKey = id)
    // 	return $this->blockLearner();
    // }
}
