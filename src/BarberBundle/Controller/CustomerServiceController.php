<?php

namespace BarberBundle\Controller;

use BarberBundle\Entity\CustomerService;
use BarberBundle\Entity\Service;
use BarberBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CustomerServiceController extends Controller
{
    /**
     * @Route("/customerservice/create/{service}/{user}")
     * @ParamConverter("service", class="BarberBundle:Service")
     * @ParamConverter("user", class="BarberBundle:User")
     */
    public function createAction(Service $service, User $user, $price = null)
    {
        if ($this->getUser()->getId() !== $user->getId()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        }

        $customerService = new CustomerService($user, $service, $price);
        $em = $this->getDoctrine()->getManager();
        $em->persist($customerService);
        $em->flush();

        $this->addFlash('info', 'Customer service is saved');

        return $this->redirectToRoute('barber_default_index');

    }

}
