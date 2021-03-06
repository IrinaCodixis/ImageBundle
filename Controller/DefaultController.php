<?php

namespace Mipa\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Mipa\ImageBundle\Entity\User

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MipaImageBundle:Default:index.html.twig', array('name' => $name));
    }
	
	public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
		$remember = $request->get('remember');
		
		// get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        return $this->render('MipaImageBundle:Default:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
}
