<?php

namespace BarberBundle\Twig;

class SumExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sum', array($this, 'sumFilter')),
        );
    }

    public function sumFilter($items, $method)
    {
        $sum = 0;
        foreach ($items as $item) {
            $sum += $item->{$method}();
        }

        return $sum;
    }

    public function getName()
    {
        return 'barber_sum';
    }
}