<?php

namespace BarberBundle\TimePeriod;

interface TimePeriod
{

    public function getStartDate();

    public function getEndDate();

    public function __toString();
}