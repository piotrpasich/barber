<?php

namespace BarberBundle\Report\QueryFilter;

use BarberBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;

class UserFilter implements QueryFilter
{
    /**
     * @var QueryFilter
     */
    private $parent;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user, QueryFilter $queryFilter = null)
    {
        $this->parent = $queryFilter;
        $this->user = $user;
    }

    public function processQuery(QueryBuilder $queryBuilder)
    {
        $queryBuilder = null == $this->parent ? $queryBuilder : $this->parent->processQuery($queryBuilder);

        $queryBuilder->andWhere('cs.user = :user')
            ->setParameter('user', $this->user->getId());

        return $queryBuilder;
    }
}