<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Learner as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Learner extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = "learner_id";

    protected $fillable = [
    	'learner_name',
    	'learner_email',
    	'learner_phone',
    	'org_no',
    	'open_password',
    	'password',
    	
    ];


    public function organization()
    {
    	// belongsTo(RelatedModel, foreignKey = organization_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Organization::class, 'org_no', 'org_id');
    }
}
