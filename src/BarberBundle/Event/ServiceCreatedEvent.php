<?php

namespace BarberBundle\Event;


use BarberBundle\Entity\ServiceEvent;
use Symfony\Component\EventDispatcher\Event;

class ServiceCreatedEvent extends Event
{
    /**
     * @var ServiceEvent
     */
    protected $serviceEvent;

    public function __construct(ServiceEvent $serviceEvent)
    {
        $this->serviceEvent = $serviceEvent;
    }

    public function getServiceEvent()
    {
        return $this->serviceEvent;
    }
}
