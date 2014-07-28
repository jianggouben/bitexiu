<?php

namespace Slackiss\Bundle\BitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="welcome")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
