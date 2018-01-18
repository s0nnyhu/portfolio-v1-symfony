<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    /**
    *
    *All function which does not render!
    *
    **/
    private function setHtmlTitle($htmlTitle ="", $mainTitle="") {
        return array("htmlTitle" => $htmlTitle,"mainTitle" => $mainTitle);
    }


    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('public/home.html.twig', self::setHtmlTitle(
            "Sonny Hu | Home", 
            ""));
    }

 	/**
     * @Route("/skill", name="skill")
     */
    public function skill() {
    	return $this->render('public/skill.html.twig', self::setHtmlTitle(
            "Sonny Hu | Skill", 
            "Skill"));
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact() {
    	return $this->render('public/contact.html.twig', self::setHtmlTitle(
            "Sonny Hu | Contact",
            "Me contacter"));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login() {
        return $this->render('public/login.html.twig', self::setHtmlTitle(
            "Sonny Hu | Contact",
            "Se connecter"));
    }
}

