<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Category;

class Instructor extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = "instr_id";

    protected $fillable = [
    	'instr_name',
    	'instr_email',
    	'instr_phone',
    	'org_no',
    	'password',
    	'open_password',
    	
    ];

    /**
     * Instructor belongs to Organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
    	// belongsTo(RelatedModel, foreignKey = organization_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Organization::class, 'org_no', 'org_id');
    }

    /**
     * Instructor has many Classes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classes()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = instructor_id, localKey = id)
        return $this->belongsToMany(Category::class, 'classes_instructors', 'cat_no', 'instr_no');
    }

    
}
