<?php

namespace BarberBundle\Report\QueryFilter;

use Doctrine\ORM\QueryBuilder;

interface QueryFilter
{
    public function processQuery(QueryBuilder $queryBuilder);
}
