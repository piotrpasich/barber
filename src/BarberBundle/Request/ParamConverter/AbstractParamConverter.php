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
abstract class AbstractParamConverter implements ParamConverterInterface
{
    protected $parameterName;

    protected function getParameter(Request $request)
    {
        foreach (['query', 'request', 'attributes'] as $field) {
            if ($request->{$field}->has($this->parameterName)) {
                return $request->{$field}->get($this->parameterName);
            }
        }

        return false;
    }

}

