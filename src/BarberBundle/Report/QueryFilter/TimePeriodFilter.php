<?php

namespace BarberBundle\Report\QueryFilter;

use BarberBundle\Entity\User;
use BarberBundle\TimePeriod\TimePeriod;
use Doctrine\ORM\QueryBuilder;

class TimePeriodFilter implements QueryFilter
{
    /**
     * @var QueryFilter
     */
    private $parent;

    /**
     * @var TimePeriod
     */
    private $timePeriod;

    public function __construct(TimePeriod $timePeriod, QueryFilter $queryFilter = null)
    {
        $this->parent = $queryFilter;
        $this->timePeriod = $timePeriod;
    }

    public function processQuery(QueryBuilder $queryBuilder)
    {
        $queryBuilder = null == $this->parent ? $queryBuilder : $this->parent->processQuery($queryBuilder);

        $queryBuilder
            ->andWhere('cs.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $this->timePeriod->getStartDate()->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $this->timePeriod->getEndDate()->format('Y-m-d H:i:s'));

        return $queryBuilder;
    }
}