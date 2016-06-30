<?php

namespace BarberBundle\Controller;

use BarberBundle\Entity\Service;
use BarberBundle\Entity\User;
use BarberBundle\Report\QueryFilter\ServiceFilter;
use BarberBundle\Report\QueryFilter\TimePeriodFilter;
use BarberBundle\Report\QueryFilter\UserFilter;
use BarberBundle\TimePeriod\TimePeriod;
use BarberBundle\TimePeriod\TodaysPeriod;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use BarberBundle\Request\ParamConverter\TimePeriodParamConverter;
use BarberBundle\Request\ParamConverter\UserParamConverter;
use BarberBundle\Request\ParamConverter\ServiceParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller
{
    /**
     * @Route("/admin/report")
     * @Template("report/report.html.twig")
     * @TimePeriodParamConverter();
     * @UserParamConverter();
     * @ServiceParamConverter();
     */
    public function reportAction(Request $request, User $user = null, TimePeriod $timePeriod = null, Service $service = null)
    {
        $searchForm = $this->createForm('BarberBundle\Form\ReportSearchType', []);

        $customerServiceRepository = $this->getDoctrine()->getRepository('BarberBundle:CustomerService');

        $searchForm->handleRequest($request);

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

        $reportItems = $customerServiceRepository->getByFilters($filter);

        return [
            'reportItems' => $reportItems,
            'searchForm' => $searchForm->createView()
        ];
    }
}
