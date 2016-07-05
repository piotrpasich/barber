<?php

namespace BarberBundle\Repository;

use BarberBundle\Entity\Service;
use BarberBundle\Entity\User;
use BarberBundle\Report\QueryFilter\QueryFilter;
use BarberBundle\Report\QueryFilter\ServiceFilter;
use BarberBundle\Report\QueryFilter\TimePeriodFilter;
use BarberBundle\Report\QueryFilter\UserFilter;
use BarberBundle\TimePeriod\TimePeriod;
use Doctrine\ORM\EntityRepository;


class CustomerServiceRepository extends EntityRepository
{

    public function getByFilters(User $user = null, TimePeriod $timePeriod = null, Service $service = null)
    {
        $filter = null;

        if (null != $timePeriod) {
            $filter = new TimePeriodFilter($timePeriod, $filter);
        }

        if (null != $user) {
            $filter = new UserFilter($user, $filter);
        }

        if (null != $service) {
            $filter = new ServiceFilter($service, $filter);
        }

        $query = $this->createQueryBuilder('cs');

        if (null != $filter) {
            $query = $filter->processQuery($query);
        }

        return $query->getQuery()->getResult();
    }

}
