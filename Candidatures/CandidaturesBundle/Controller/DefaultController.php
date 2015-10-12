<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Controller;

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
        return $this->render('CandidaturesBundle:Default:index.html.twig');
    }
}
