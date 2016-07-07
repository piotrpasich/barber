<?php

namespace BarberBundle\Request\ParamConverter;

use BarberBundle\Report\QueryFilter\TimePeriodFilter;
use BarberBundle\TimePeriod\DateRangePeriod;
use BarberBundle\TimePeriod\TimePeriodCollection;
use BarberBundle\TimePeriod\TodaysPeriod;
use BarberBundle\TimePeriod\WeeklyPeriod;
use Psr\Log\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
/**
 * @Annotation
 */
class TimePeriodParamConverter extends AbstractParamConverter
{
    protected $parameterName = 'timePeriod';
    protected $parameterNameFrom = 'timePeriodFrom';
    protected $parameterNameTo = 'timePeriodTo';

    public function apply(Request $request, ParamConverter $configuration)
    {
        $namedParameterResult = $this->applyNamedParameter($request, $configuration);

        if (!$namedParameterResult) {
            return $this->applyRangeParameter($request, $configuration);
        }

        return $namedParameterResult;
    }

    protected function applyRangeParameter(Request $request, ParamConverter $configuration)
    {
        $from = $this->getParameter($request, $this->parameterNameFrom);
        $to = $this->getParameter($request, $this->parameterNameTo);

        if (!$from && !$to) {
            return false;
        }

        $period = new DateRangePeriod(new DateTime($from), new DateTime($to));

        $request->attributes->set($this->parameterName, $period);

        return true;
    }

    protected function applyNamedParameter(Request $request, ParamConverter $configuration)
    {
        $param = $this->getParameter($request);

        if (!$param) {
            return false;
        }

        $period = null;

        try {
            $period = (new TimePeriodCollection())->match($param);
        } catch (\Exception $e) {
            return false;
        }

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

