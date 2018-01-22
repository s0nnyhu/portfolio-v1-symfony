<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class RedirectingController extends Controller
{

	/**
     * @Route("/{url}", name="removeTrailingSlash", 
     * 	requirements={"url" = ".*\/$"}, methods={"GET"})
     */
    public function removeTrailingSlash(Request $request) {
    	$pathInfo = $request->getPathInfo();

        $requestUri = $request->getRequestUri();
        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);
        $rep = $http->getStatusCode();
        //return $this->redirect($url, 301);
        return new Response("hello");
    }

}
