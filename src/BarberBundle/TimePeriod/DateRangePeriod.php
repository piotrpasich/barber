<?php

namespace BarberBundle\TimePeriod;

use DateTime;

class DateRangePeriod implements TimePeriod
{

    /**
     * @var DateTime
     */
    protected $from;

    /**
     * @var DateTime
     */
    protected $to;

    public function __construct(DateTime $from, DateTime $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getStartDate()
    {
        return $this->from;
    }

    public function getEndDate()
    {
        return $this->to;
    }

    public function __toString()
    {
        return 'Range';
    }
}
