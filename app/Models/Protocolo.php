<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocolo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tel_extension',
        'notes_cta',
        'notes_protocolo',
        'notes_general_service',
        'link',
        'event_id'

    ];
/*ikjjk */ 
    public function event(){
        return $this->belongsTo(Event::class);
    }
}
