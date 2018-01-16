<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('public/home.html.twig', array('htmlTitle' => "Sonny Hu | Home", "mainTitle" => ""));
    }

 	/**
     * @Route("/skill", name="skill")
     */
    public function skill() {
    	return $this->render('public/skill.html.twig', array('htmlTitle' => "Sonny Hu | Skill", "mainTitle" => "Skill"));
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact() {
    	return $this->render('public/contact.html.twig', array('htmlTitle' => "Sonny Hu | Contact", "mainTitle" => "Me contacter"));
    }
}

