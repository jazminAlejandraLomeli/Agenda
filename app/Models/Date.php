<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Date extends Model
{
    /*ikjjk */ 
    use HasFactory;
    

    protected $fillable = [
        'date_start',
        'date_end',
    ];

    
    public function event() : BelongsTo {
        return $this->belongsTo(Event::class);
    }

    protected function startDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->date_start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')),            
        );
    }

    protected function startHour(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->date_start)->locale('es')->format('h:i a'),
        );
    }

    protected function endHour(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->date_end)->locale('es')->format('h:i a'),
        );
    }

    // Si quieres que aparezca en JSON/arrays, agrégalo a $appends
    protected $appends = ['start_date_formatted','start_hour','end_hour'];
}
