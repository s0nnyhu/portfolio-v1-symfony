<?php

namespace App\Controller;
use App\Entity\Message;
use App\Form\FormMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Article;
use App\Service\GetClientInfo;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    public function index(GetClientInfo $getClientInfo, SessionInterface $session) {   

        if($session->isStarted() === false) {
            $session->start();
            $session->set('ip', $getClientInfo->getIp());
            $getClientInfo->getClientData($session);
        }
        
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
     * @Route("/article/{slug}", name="articleId")
     */

    public function articleView($slug, Request $request)
    {
        $article = $this->getDoctrine()
                        ->getManager()
                        ->getRepository(Article::class)
                        ->findOneBy(
                            ['slug' => $slug]);
        if (!$article) {
           return $this->render('public/devnull.html.twig',self::setHtmlTitle(
                "Sonny Hu | Erreur", 
                "Erreur"));
        }
        return $this->render('public/article.html.twig',array("title" => $article->getTitle(), "content" => $article->getContent()));
    }


    /**
     * @Route("/projets/{page}", name="projets", defaults={"page"="1"})
     */

    public function articleList($page, Request $request)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        if (!$articles) {
            return $this->render('public/devnull.html.twig',self::setHtmlTitle(
                "Sonny Hu | Erreur", 
                "Erreur"));
        }

        $articlesPaginated=$this->get('knp_paginator')->paginate(
            $articles, $request->query->get('page', $page),6);
        $articlesPaginated->setUsedRoute('projets');
        return $this->render('public/project.html.twig', array('articles' => $articlesPaginated));
    }

}

