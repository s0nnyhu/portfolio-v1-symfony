<?php

namespace App\Controller;
use App\Entity\Message;
use App\Form\FormMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
    *
    *All function which does not render!
    *
    **/
    public function setHtmlTitle($htmlTitle ="", $mainTitle="") {
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
    public function contact(Request $request) {
        $message = new Message();
        $formMessage = $this->createForm(FormMessageType::class, $message);
        
        $formMessage->handleRequest($request);

        if ($formMessage->isSubmitted() && $formMessage->isValid()) {
            try {
                $messageData = $formMessage->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($messageData);
                $em->flush();
                $this->addFlash('sent', 'Your message has been sent :]');
            } catch(\Doctrine\DBAL\DBALException $e) {
                $this->addFlash(
                'notSent',
                'An error occured, message not sent :[');
                return $this->redirectToRoute('contact');
            }
            
            return $this->redirectToRoute('contact');

        } elseif($formMessage->isSubmitted() && $formMessage->isValid()==false) {
            $this->addFlash(
                'notSent',
                'An error occured, message not sent :[');
            return $this->redirectToRoute('contact');
        }
        return $this->render('public/contact.html.twig', array("htmlTitle" => "Sonny Hu | Contact","mainTitle" => "Me contacter", 'formMessage' =>$formMessage->createView()));
    }

    /**
    *@Route("/getPost", name="getPost")
    */
    public function test(Request $request) {
        $post = $request->request->get('hello');
        if(isset($post)) {
            return new Response("hello");
        } else {
             return $this->render("public/test.html.twig", self::setHtmlTitle(
            "Sonny Hu | Skill", 
            ":["));
        }
            
        
       
    }


}

