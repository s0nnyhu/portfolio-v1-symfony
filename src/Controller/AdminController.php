<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\File;
use App\Form\FormFileType;
use App\Form\FormArticleType;
use App\Repository\ArticleRepository;


class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('admin/adbase.html.twig');
    }

    /**
     * @Route("/admin/add", name="addArticle")
     */
    public function add(Request $request)
    {
        $article = new Article();
        $formArticle = $this->createForm(FormArticleType::class, $article, array('attr' => ['id' => 'task-form'],'upOrAdd'=>'Add this'));

        $file = new File(); 

        $formFile = $this->createForm(FormFileType::class, $file, ['attr' => ['id' => 'formFile']]);
        $formFile->handleRequest($request);

        if ($formFile->isSubmitted() && $formFile->isValid()) {
            try {
                $fileData=$formFile->getData();
                $em=$this->getDoctrine()->getManager();
                $em->persist($fileData);
                $em->flush();
                $fileToUpload = $formFile['file']->getData();
                $file_name = $fileData->getFileName();
                $file_ext = $fileData->getFileType();
                /*
                * $dir edited, recheck t
                */
                $dir=$this->getParameter('upload_directory');
                $fileToUpload->move($dir, $file_name);
                return new JsonResponse(["isOk" => "ok"]);
            } catch(\Exception $e) {
                return $this->redirectToRoute('addArticle');
            }

        } 

        $formArticle->handleRequest($request);
        if ($formArticle->isSubmitted() && $formArticle->isValid()) {
            try {
                $articleData=$formArticle->getData();
                $em=$this->getDoctrine()->getManager();
                $em->persist($articleData);
                $em->flush();
            } catch(\Exception $e) {
               $this->addFlash(
                'notAdded',
                'An error occured, article not added :[');
                return $this->redirectToRoute('addArticle');
            }
                $this->addFlash(
                        'added',
                        'Article has been added');
                return $this->redirectToRoute('addArticle');
           
        } elseif($formArticle->isSubmitted() && $formArticle->isValid()==false) {
        	$this->addFlash(
                'notAdded',
                'An error occured, article not added :[');
            return $this->redirectToRoute('addArticle');
        }

        return $this->render('admin/core/add.html.twig', array('formArticle' =>$formArticle->createView(), 'formFile' =>$formFile->createView()));

    }

    /**
     * @Route("/admin/manage", name="manageArticle")
     */
    public function manage()
    {
        try {
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
            if (!$articles) {
                throw $this->createNotFoundException(
                    'No artice found ');  
            }
        } catch (\Exception $e) {
            return $this->render('admin/core/devnull.html.twig');
        }
        

        foreach ($articles as $article) {
           $output[] = array($article->getTitle(), $article->getSlug());
        }
        return $this->render('admin/core/manage.html.twig', array('articles' => $articles));
    }

     /**
    * @Route("/admin/manage/edit/status/", name="editPublicStatus")
    */
    public function changePublicStatus(Request $request) {
        if($request->isXmlHttpRequest()) {
           $status= $request->query->get('status');
           $id= $request->query->get('id');
           $article = $this->getDoctrine()->getRepository(Article::class)->updateStatus($status, $id);
           return new JsonResponse(["isPublic" => $status, "status"=> "updated", "id" => $id]);
        } else {
            return New Response("Not ajax request");
        }
    }
}
