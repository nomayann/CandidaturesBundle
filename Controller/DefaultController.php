<?php

namespace NomayaCandidaturesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * Show a page resuming activity.
     *
     * @Route("/mama", name="home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('NomayaCandidaturesBundle:Default:index.html.twig');
    }
}
