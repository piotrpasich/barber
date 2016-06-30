<?php

namespace BarberBundle\Builder;

use BarberBundle\Entity\Service;
use BarberBundle\Entity\ServiceEvent;
use BarberBundle\Entity\User;

class ServiceEventBuilder
{
    public function create(Service $service, User $user)
    {
        $serviceEvent = new ServiceEvent($user);
        $serviceEvent->setEnabled($service->getEnabled());
        $serviceEvent->setName($service->getName());
        $serviceEvent->setPrice($service->getPrice());

        return $serviceEvent;
    }
}