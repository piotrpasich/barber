<?php

namespace BarberBundle\Request\ParamConverter;

use BarberBundle\TimePeriod\TodaysPeriod;
use Psr\Log\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Annotation
 */
class TimePeriodParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = 'timePeriod';

        if (!$request->attributes->has($param)) {
            return false;
        }

        $period = null;

        switch ($request->attributes->get($param)) {
            case 'today':
                $period = new TodaysPeriod();

        }

        $request->attributes->set($param, $period);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return $configuration->getClass() === 'BarberBundle\TimePeriod\TimePeriod';
    }
}

