<?php

namespace Slackiss\Bundle\BitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ManagerController extends Controller
{
    /**
     * @Route("/manager",name="manager")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
