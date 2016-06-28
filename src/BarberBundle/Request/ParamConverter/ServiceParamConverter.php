<?php

namespace BarberBundle\Request\ParamConverter;

use BarberBundle\Repository\UserRepository;
use BarberBundle\TimePeriod\TodaysPeriod;
use Psr\Log\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Annotation
 */
class ServiceParamConverter extends AbstractParamConverter
{
    protected $parameterName = 'service';

    /**
     * @var UserRepository
     */
    protected $serviceRepository;

    public function __construct($serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $serviceId = $this->getParameter($request);

        if (!$serviceId) {
            return false;
        }

        $user = $this->serviceRepository->find($serviceId);

        $request->attributes->set($this->parameterName, $user);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return $configuration->getClass() === 'BarberBundle\Entity\Service';
    }
}

