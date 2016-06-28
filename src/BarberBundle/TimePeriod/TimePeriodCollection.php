<?php

namespace BarberBundle\TimePeriod;


use Psr\Log\InvalidArgumentException;

class TimePeriodCollection
{

    protected $periods = [];

    public function __construct()
    {
        $this->periods[] = new TodaysPeriod();
        $this->periods[] = new MonthlyPeriod();
        $this->periods[] = new WeeklyPeriod();
    }

    public function toArray()
    {
        return array_combine(
            array_map(function (TimePeriod $period) {
                return (string)$period;
            }, $this->periods),
            array_map(function (TimePeriod $period) {
                return (string)$period;
            }, $this->periods)
        );
    }

    public function match($periodName)
    {
        foreach ($this->periods as $period) {
            if ($periodName == (string)$period) {
                return $period;
            }
        }

        throw new InvalidArgumentException('Wrong period argument');
    }

}