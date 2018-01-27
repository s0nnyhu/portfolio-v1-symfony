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
    public function contact(Request $request, ValidatorInterface $validator, \Swift_Mailer $mailer) {
        $message = new Message();
        $formMessage = $this->createForm(FormMessageType::class, $message);
        
        $formMessage->handleRequest($request);

        if ($formMessage->isSubmitted() && $formMessage->isValid()) {
                $messageData = $formMessage->getData();
                $message = nl2br($messageData->getMessage());
                $email = $messageData->getEmail();
                //Add to database
                $em = $this->getDoctrine()->getManager();
                $em->persist($messageData);
                $em->flush();
                //Send email to admin
                $mailAdmin = (new \Swift_Message('A message received husonny.fr'))
                                ->setFrom('contact@husonny.fr')
                                ->setTo(['contact@husonny.fr',
                                        'husonny1@gmail.com'])
                                ->setBody($message, 'text/html');
                $mailer->send($mailAdmin);

                //Send mail to visitor
                $mailVisitor = (new \Swift_Message('Contact@husonny.fr'))
                                ->setFrom('contact@husonny.fr')
                                ->setTo($email)
                                ->setBody($this->renderView('email/visitor.html.twig'), 'text/html');
                $mailer->send($mailVisitor);

                //Redirect
                $this->addFlash('sent', 'Your message has been sent :]');
                return $this->redirectToRoute('contact');
                
                return new Response ($message);


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

public function test()
{
   
    return new Response("je");
}

}

