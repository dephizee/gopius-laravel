<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
        'org_size' ,
        'org_priority' ,
        'org_why' ,
        'org_type_no',
        'org_address' ,
        'state_no' ,
        'about_org' ,
        'password' ,
        'remember_token',
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

    /**
     * Organization has one Verificat_table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verification()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = organization_id, localKey = id)
        return $this->hasOne(VerifyOrganizationTable::class, 'org_no', 'org_id');
    }

    /**
     * Organization has one Setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setting()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = organization_id, localKey = id)
        return $this->hasOne(Setting::class, 'org_no', 'org_id');
    }

    /**
     * Organization belongs to State.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        // belongsTo(RelatedModel, foreignKey = state_id, keyOnRelatedModel = id)
        return $this->belongsTo(State::class, 'state_no', 'id');
    }
}
