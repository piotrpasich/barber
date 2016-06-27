<?php

namespace BarberBundle\TimePeriod;

use DateTime;

class TodaysPeriod implements TimePeriod
{

    public function getStartDate()
    {
        return new DateTime('today 00:00:00');
    }

    public function getEndDate()
    {
        return new DateTime('today 23:59:59');
    }
}
