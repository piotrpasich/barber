<?php

namespace BarberBundle\Controller;

use BarberBundle\Entity\CustomerService;
use BarberBundle\Entity\Service;
use BarberBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CustomerServiceController extends Controller
{
    /**
     * @Route("/customerservice/create/{service}/{user}")
     * @ParamConverter("service", class="BarberBundle:Service")
     * @ParamConverter("user", class="BarberBundle:User")
     */
    public function createAction(Request $request, Service $service, User $user, $price = null)
    {
        if ($this->getUser()->getId() !== $user->getId()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        }

        if (null === $price && $request->query->has('price')) {
            $price = (int)$request->get('price');
        }

        $customerService = new CustomerService($user, $service, $price);
        $em = $this->getDoctrine()->getManager();
        $em->persist($customerService);
        $em->flush();

        $this->addFlash('info', 'Customer service is saved');

        return $this->redirectToRoute('barber_default_index');
    }

    /**
     * @Route("/customerservice/form/{service}/{user}")
     *
     * @ParamConverter("service", class="BarberBundle:Service")
     * @ParamConverter("user", class="BarberBundle:User")
     *
     * @Template("customerservice/form.html.twig")
     */
    public function formAction(Request $request, Service $service, User $user)
    {
        $customerService = new CustomerService($user, $service, 0);

        $form = $this->createForm('BarberBundle\Form\CustomerServiceType', $customerService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('barber_customerservice_create', [
                'service' => $service->getId(),
                'user' => $user->getId(),
                'price' => $customerService->getPrice()
            ]);
        }

        return [
            'form' => $form->createView(),
            'service' => $service,
            'user' => $user
        ];
    }

}
