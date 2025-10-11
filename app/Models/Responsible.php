<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group_id'
    ];
/*ikjjk */ 
    public function events()
    {
        return $this->hasMany(Event::class,'responsible_id','id');
    }
}
