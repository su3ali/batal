<?php
namespace App\Traits;

use Carbon\Carbon;


trait schedulesTrait{

    function getTime($day, $booking): string
    {

        $days = ['Saturday', 'Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $chooseDate = array_search($day, $days);
        $startDate = array_search($booking->service_start_date, $days);
        $endDate = array_search($booking->service_end_date, $days);

        if(in_array($chooseDate, range($startDate, $endDate))) {
            $time = true;
        }else{
            $time = false;
        }

    return $time;
    }

}
