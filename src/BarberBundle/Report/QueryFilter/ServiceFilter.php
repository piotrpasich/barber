<?php

namespace BarberBundle\Report\QueryFilter;

use BarberBundle\Entity\Service;
use BarberBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;

class ServiceFilter implements QueryFilter
{
    /**
     * @var QueryFilter
     */
    private $parent;

    /**
     * @var Service
     */
    private $service;

    public function __construct(Service $service, QueryFilter $queryFilter = null)
    {
        $this->parent = $queryFilter;
        $this->service = $service;
    }

    public function processQuery(QueryBuilder $queryBuilder)
    {
        $queryBuilder = null == $this->parent ? $queryBuilder : $this->parent->processQuery($queryBuilder);

        $queryBuilder->andWhere('cs.service = :service')
            ->setParameter('service', $this->service->getId());

        return $queryBuilder;
    }
}