<?php

namespace Mipa\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MipaImageBundle:Default:index.html.twig', array('name' => $name));
    }
}
