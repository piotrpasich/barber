<?php

namespace BarberBundle\Builder;

use BarberBundle\Entity\Service;
use BarberBundle\Entity\ServiceEvent;

class ServiceBuilder
{
    public function create(ServiceEvent $serviceEvent)
    {
        return new Service($serviceEvent->getName(), $serviceEvent->getPrice(), $serviceEvent->getEnabled());
    }
}