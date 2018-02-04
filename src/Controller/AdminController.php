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
use App\Service\GetClientInfo;


class AdminController extends Controller
{

    /**
     * @Route("/shu", name="shu")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->redirectToRoute('dashboard');
    }



    /**
     * @Route("/browser", name="getBrowser")
     */
    public function browserStat(GetClientInfo $clientInfo)
    {
        $browsers = $clientInfo->getBrowserStats();
        return new Response(var_dump(array_keys($browsers)));
    }

    /**
     * @Route("/os", name="getOs")
     */
    public function osStat(GetClientInfo $clientInfo)
    {
        $os = $clientInfo->getOsStats();
        return new JsonResponse($os);

    }



    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function dashboard()
    {

        return $this->render('admin/core/dashboard.html.twig');
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
     * @Route("/admin/manage/article", name="manageArticle")
     */
    public function manageArticle()
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
     * @Route("/admin/manage/file", name="manageFile")
     */
    public function manageFile()
    {
        try {
            $files = $this->getDoctrine()->getRepository(File::class)->findAll();
            if (!$files) {
                throw $this->createNotFoundException(
                    'No artice found ');  
            }
        } catch (\Exception $e) {
            return $this->render('admin/core/devnull.html.twig');
        }
        

        return $this->render('admin/core/fileManage.html.twig', array('files' => $files));
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

    /**
     * @Route("/admin/manage/article/edit/{id}", name="editArticle", requirements={"id"="\d+"})
     */

    public function editArticle($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $formArticle = $this->createForm(FormArticleType::class, $article, array('attr' => ['id' => 'task-form'],'upOrAdd'=>'Update this'));
        if (!$article) {
            return ('admin/core/devnull.html.twig');
        }

        //Manage file form and submit
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
                return $this->redirectToRoute('editArticle', array('id' => $id));
            }
        } 

        //Manage article update
        $formArticle->handleRequest($request);
        if ($formArticle->isSubmitted() && $formArticle->isValid()) {
            try {
                $articleData=$formArticle->getData();
                $em->flush();
            } catch(\Exception $e) {
               $this->addFlash(
                'notUpdated',
                'An error occured, update failed :[');
                return $this->redirectToRoute('editArticle', array('id' => $id));
            }
                $this->addFlash(
                        'updated',
                        'Article has been updated successfully');
                return $this->redirectToRoute('editArticle', array('id' => $id));
           
        } elseif($formArticle->isSubmitted() && $formArticle->isValid()==false) {
            $this->addFlash(
                'notUpdated',
               'An error occured, update failed :[');
            return $this->redirectToRoute('editArticle', array('id' => $id));
        }

        return $this->render('admin/core/editArticle.html.twig', array('formArticle' =>$formArticle->createView(), 'formFile' =>$formFile->createView(), 'article' => $article));

    }

    /**
    *@Route("/admin/manage/article/delete/{id}", name="deleteArticle", requirements={"id"="\d+"})
    */
    public function deleteArticle($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        if(!$article) {
            throw $this->createNotFoundException(
                'Article not found');
        }
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('manageArticle');
    }

    
}
