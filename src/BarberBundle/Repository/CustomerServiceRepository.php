<?php

namespace BarberBundle\Repository;

use BarberBundle\Report\QueryFilter\QueryFilter;
use BarberBundle\TimePeriod\TimePeriod;
use Doctrine\ORM\EntityRepository;


class CustomerServiceRepository extends EntityRepository
{

    public function getByFilters(QueryFilter $queryFilter = null)
    {
        $query = $this->createQueryBuilder('cs');

        if (null != $queryFilter) {
            $query = $queryFilter->processQuery($query);
        }

        return $query->getQuery()->getResult();
    }
}
