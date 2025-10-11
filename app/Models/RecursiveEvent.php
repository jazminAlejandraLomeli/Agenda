<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecursiveEvent extends Model
{
    use HasFactory;
/*ikjjk */ 
    protected $fillable = [
        'event_group'
    ];

    public function event() : BelongsTo{
        return $this->belongsTo(Event::class,'id','event_id');
    }
}
