<?php 
namespace App\Services;

use Carbon\Carbon;

class DatesFoundService
{
    public function getDatesRangeFound($request) : array    
    {

        $dateStart = Carbon::parse($request->input('date_start'));
        $repetition = $request->input('repetition', 0);
        $hourStart = $request->input('hour_start');
        $hourEnd = $request->input('hour_end');

        $dateFounds = [];

        if ($repetition == 1) {

            $dateEnd = Carbon::parse($request->input('date_end'));
            $daysSelected = $request->input('days', []);

            for ($dateCopy = $dateStart->copy(); $dateCopy->lte($dateEnd); $dateCopy->addDay()) {
                if (in_array($dateCopy->dayOfWeek, $daysSelected)) {
                    $dateFounds[] = [
                        'date_start' => $dateCopy->format('Y-m-d') . ' ' . $hourStart,
                        'date_end' => $dateCopy->format('Y-m-d') . ' ' . $hourEnd,
                    ];
                }
            }
        } else {

            $dateFormatStart = $dateStart->format('Y-m-d');

            $dateFounds = [
                [
                    'date_start' => $dateFormatStart  . ' ' . $hourStart,
                    'date_end' => $dateFormatStart . ' ' . $hourEnd,
                ]
            ];
        }

        return $dateFounds;
    }
}