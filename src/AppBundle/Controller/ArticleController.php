<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Categorie;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;


class ArticleController extends Controller
{

    /**
    * @Rest\View(serializerGroups={"article"})
    * @Rest\Get("articles")
    */
    public function getArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $articles;
    }

    /**
    * @Rest\View(serializerGroups={"article"})
    * @Rest\Get("article/{id}", name="_foo")
    */
    public function getArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (empty($article)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $article;
    }

    /**
    * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"article"})
    * @Rest\Post("articles")
    */
    public function postArticleAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->submit($request->request->all()); // Validation des données
        
        if ($form->isValid()) {
            $em->persist($article);
            $em->flush();
            return $article;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(serializerGroups={"article"})
     * @Rest\Patch("article/{id}")
     */

    public function patchArticleAction($id, Request $request){
        
        return $this->updateArticleAction($id, $request, false);
    }

    /**
     * @Rest\View(serializerGroups={"article"})
     * @Rest\Put("article/{id}")
     */
    public function putArticleAction($id, Request $request){
        
       return $this->updateArticleAction($id, $request, true);
    }


    private function updateArticleAction($id, Request $request, $clearMissing){
        
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (empty($article)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ArticleType::class, $article);
        
        $form->submit($request->request->all(), $clearMissing);

        if($form->isValid()){
            $em->merge($article);
            $em->flush();
            return $article;
        } else {
            return $form;
        }
    }
    

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("article/{id}")
     */
    public function deleteArticleAction($id){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (empty($article)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        if($article){
            $em->remove($article);
            $em->flush();
        }
    }
}
