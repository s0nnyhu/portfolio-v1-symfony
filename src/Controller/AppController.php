<?php

namespace App\Controller;
use App\Entity\Message;
use App\Form\FormMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function contact(Request $request, ValidatorInterface $validator) {
        $message = new Message();
        $formMessage = $this->createForm(FormMessageType::class, $message);
        
        $formMessage->handleRequest($request);

        if ($formMessage->isSubmitted() && $formMessage->isValid()) {
                $messageData = $formMessage->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($messageData);
                $em->flush();
                $this->addFlash('sent', 'Your message has been sent :]');
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
     * @Route("/test", name="test")
     */

public function sendEmail(\Swift_Mailer $mailer)
{
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('contact@husonny.fr')
        ->setTo([
          'contact@husonny.fr',
          'debroot4@gmail.com' => 'Person 2 Name',
        ])
        ->setBody('You shsdsdsdsdsdsdsould see me from the profiler!')
    ;

    $mailer->send($message);

    return new Response("je");
}

}

