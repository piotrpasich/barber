<?php

namespace BarberBundle\Response;

use BarberBundle\Entity\CustomerService;
use Symfony\Component\HttpFoundation\Response;

class ReportCsvResponse extends Response
{

    public function __construct($reportItems)
    {

        $content = implode("\n", array_map( function (CustomerService $customerService) {
            return implode(';', [
                $customerService->getUser()->getUsername(),
                $customerService->getService()->getName(),
                $customerService->getCreatedAt()->format('Y-m-d H:i:s')
            ]);
        } , $reportItems));

        parent::__construct($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="raport.csv"'
        ]);
    }

}