<?php

namespace BarberBundle\Request\ParamConverter;

use BarberBundle\TimePeriod\TimePeriodCollection;
use BarberBundle\TimePeriod\TodaysPeriod;
use Psr\Log\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Annotation
 */
class TimePeriodParamConverter extends AbstractParamConverter
{
    protected $parameterName = 'timePeriod';

    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $this->getParameter($request);

        if (!$param) {
            return false;
        }

        $period = null;

        try {
            $period = (new TimePeriodCollection())->match($param);
        } catch (\Exception $e) {}

        $request->attributes->set($this->parameterName, $period);

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

