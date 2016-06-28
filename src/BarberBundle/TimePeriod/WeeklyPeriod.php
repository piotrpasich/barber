<?php

namespace BarberBundle\TimePeriod;

use DateTime;

class WeeklyPeriod implements TimePeriod
{

    public function getStartDate()
    {
        return new DateTime('last monday 00:00:00');
    }

    public function getEndDate()
    {
        return new DateTime('today 23:59:59');
    }

    public function __toString()
    {
        return 'Weekly';
    }
}
