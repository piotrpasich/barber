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
class UserParamConverter extends AbstractParamConverter
{
    protected $parameterName = 'user';

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $userId = $this->getParameter($request);

        if (!$userId) {
            return false;
        }

        $user = $this->userRepository->find($userId);

        $request->attributes->set($this->parameterName, $user);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return $configuration->getClass() === 'BarberBundle\Entity\User';
    }
}

