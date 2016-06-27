<?php

namespace BarberBundle\EventListener;


use BarberBundle\Builder\ServiceBuilder;
use BarberBundle\Event\ServiceCreatedEvent;
use BarberBundle\Repository\ServiceRepository;

class ServiceCreatedEventListener
{

    /**
     * @var ServiceBuilder
     */
    protected $serviceBuilder;

    /**
     * @var ServiceRepository
     */
    protected $serviceRepository;

    public function __construct(ServiceBuilder $serviceBuilder, ServiceRepository $serviceRepository)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->serviceRepository = $serviceRepository;
    }

    public function created(ServiceCreatedEvent $serviceCreatedEvent)
    {
        $service = $this->serviceBuilder->create($serviceCreatedEvent->getServiceEvent());
        $this->serviceRepository->save($service);
    }

}