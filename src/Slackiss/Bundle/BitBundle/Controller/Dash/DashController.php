<?php

namespace Slackiss\Bundle\BitBundle\Controller\Dash;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashController extends Controller
{
    /**
     * @Route("/dash",name="dash")
     * @Template()
     */
    public function dashAction()
    {
        return array();
    }
}
