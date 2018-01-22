<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
    	if($request->getMethod() == 'POST') {
    		$username = $request->request->get('username');
	    	if (isset($username)) {
	    		return  new Response ("not isset");
	    	}
    	}


       	return $this->render('public/login.html.twig', array("htmlTitle" => "d","mainTitle" => "df"));
    }
}
