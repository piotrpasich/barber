<?php

namespace BarberBundle\Controller;

use BarberBundle\Entity\User;
use BarberBundle\Report\QueryFilter\TimePeriodFilter;
use BarberBundle\Report\QueryFilter\UserFilter;
use BarberBundle\TimePeriod\TimePeriod;
use BarberBundle\TimePeriod\TodaysPeriod;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use BarberBundle\Request\ParamConverter\TimePeriodParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller
{
    /**
     * @Route("/admin/report/{timePeriod}")
     * @Route("/admin/report/{timePeriod}/user/{user}")
     * @Route("/admin/report/user/{user}")
     * @Template("report/report.html.twig")
     * @TimePeriodParamConverter();
     */
    public function reportAction(Request $request, User $user = null, TimePeriod $timePeriod = null)
    {
        $searchForm = $this->createForm('BarberBundle\Form\ReportSearchType', []);

        $customerServiceRepository = $this->getDoctrine()->getRepository('BarberBundle:CustomerService');

        $filter = null;

        if (null != $timePeriod) {
            $filter = new TimePeriodFilter($timePeriod);
        }

        if (null != $user) {
            $filter = new UserFilter($user);
        }

        $reportItems = $customerServiceRepository->getByFilters($filter);

        return [
            'reportItems' => $reportItems,
            'searchForm' => $searchForm->createView()
        ];
    }
}
