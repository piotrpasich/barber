<?php

namespace BarberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template("BarberBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        if ( ! $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('BarberBundle:Service')->findAll();
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $users = $em->getRepository('BarberBundle:User')->findAllVisible();
        } else {
            $users = [$this->getUser()];
        }

        return [
            'services' => $services,
            'users' => $users
        ];
    }
}
