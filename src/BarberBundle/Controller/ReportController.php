<?php

namespace BarberBundle\Controller;

use BarberBundle\Entity\CustomerService;
use BarberBundle\Entity\Service;
use BarberBundle\Entity\User;
use BarberBundle\Report\QueryFilter\ServiceFilter;
use BarberBundle\Report\QueryFilter\TimePeriodFilter;
use BarberBundle\Report\QueryFilter\UserFilter;
use BarberBundle\Response\ReportCsvResponse;
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
     * @Route("/admin/report.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_format": "html|csv",
     *     })
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

        $reportItems = $customerServiceRepository->getByFilters($user, $timePeriod, $service);

        switch ($request->get('_format')) {
            case 'csv':
                return new ReportCsvResponse($reportItems);
                break;
            default:
                return [
                    'reportItems' => $reportItems,
                    'searchForm' => $searchForm->createView()
                ];
        }
    }

    /**
     * @Template("report/user_summary.html.twig")
     * @TimePeriodParamConverter();
     * @UserParamConverter();
     * @ServiceParamConverter();
     */
    public function userSummaryAction(User $user, TimePeriod $timePeriod = null)
    {
        if (null === $timePeriod) {
            $timePeriod = new TodaysPeriod();
        }

        $customerServiceRepository = $this->getDoctrine()->getRepository('BarberBundle:CustomerService');

        $reportItems = $customerServiceRepository->getByFilters($user, $timePeriod, null);

        return [
            'sum' => array_reduce($reportItems, function ($sum, CustomerService $customerService) {
                return $sum += $customerService->getPrice();
            })
        ];
    }
}
