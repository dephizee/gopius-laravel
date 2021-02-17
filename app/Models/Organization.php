<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Organization as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Organization extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = "org_id";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'firstname' ,
        'lastname' ,
        'email' ,
        'phone' ,
        'org_name' ,
        'org_type_no',
        'org_address' ,
        'state_no' ,
        'about_org' ,
        'password' ,
    ];

    /**
     * Organization belongs to Org_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function org_type()
    {
        // belongsTo(RelatedModel, foreignKey = org_type_id, keyOnRelatedModel = id)
        return $this->belongsTo(OrganizationType::class, 'org_type_no', 'org_type_id');
    }
}
