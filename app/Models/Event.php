<?php

namespace App\Models;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'type_id',
        'dependency_program_id',
        'place_id',
        'group_id',
        'date_id',
        'responsible_id',
        'description',
        'created_by'
    ];


    // Relationship with the event_type table
    public function event_type(): HasOne
    {
        return $this->hasOne(Event_type::class,'id','type_id');
    }
/*ikjjk */ 
    // Relationship with the dependency_program table
    public function dependency_program(): HasOne
    {
        return $this->hasOne(Dependency_program::class,'id','dependency_program_id');
    }

    // Relationship with the place table
    public function place(): HasOne
    {
        return $this->hasOne(Place::class,'id','place_id');
    }

    // Relationship with the user table
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','created_by');
    }

    // Relationship with the protocolo table
    public function protocolo(): HasOne
    {
        return $this->hasOne(Protocolo::class,'event_id','id');
    }

    public function date() : HasOne
    {
        return $this->hasOne(Date::class,'id','date_id');
    }

    public function cta() : HasOne
    {
        return $this->hasOne(Cta::class,'event_id','id');
    }

    public function group() : HasOne
    {
        return $this->hasOne(Group::class,'id','group_id');
    }

    public function responsible() : HasOne
    {
        return $this->hasOne(Responsible::class,'id','responsible_id');
    }

    public function recursive_event() : HasOne {
        return $this->hasOne(RecursiveEvent::class,'event_id','id');
    }

}
