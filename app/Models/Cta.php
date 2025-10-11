<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    use HasFactory;
/*ikjjk */ 
    protected $fillable = [
        'email',
        'event_id',
        'num_participants',
        'semester_id',
        'published'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
