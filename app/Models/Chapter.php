<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $primaryKey = "chapter_id";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'chapter_title',
    	'course_no',
    ];

    /**
     * Chapter has many Blocks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = chapter_id, localKey = id)
    	return $this->hasMany(Block::class, 'chapter_no', 'chapter_id');
    }
}
