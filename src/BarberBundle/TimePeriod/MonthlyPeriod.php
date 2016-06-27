<?php

namespace BarberBundle\TimePeriod;

use DateTime;

class MonthlyPeriod implements TimePeriod
{

    private $month;
    private $year;

    public function __construct($year = null, $month = null)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function getStartDate()
    {
        return new DateTime('first day of this month');
    }

    public function getEndDate()
    {
        return new DateTime('first last of this month');
    }
}
