<?php

namespace Mipa\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Mipa\ImageBundle\Entity\User;

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
		
		
		$em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MipaImageBundle:User');
		
		
		if ($request->getMethod() == 'POST') {
			
			$remember = $request->get('remember');
			// get the login error if there is one
			if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
				$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
			} else {
				if ($remember=='remember-me') {
				$login = new User();
				$login->setUsername($username);
				$login->setPassword($password);
				$session->set('login', $login);
				}
			
				$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
				$session->remove(SecurityContext::AUTHENTICATION_ERROR);
			}
		}
		else {
			if ($session->has('login')) {
				$login = $session->get('login');
				$username = $login->getUsername();
				$password = $login->getPassword();
				$user = $repo->findOneBy(array('userName' => $username, '$password' => $password));
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
	
}
