<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
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
    * @Rest\View()
    * @Rest\Get("articles")
    */
    public function getArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findAll();

        if (empty($articles)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $articles;
    }

    /**
    * @Rest\View()
    * @Rest\Get("article/{id}")
    */
    public function getArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (empty($article)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $article;
    }

    /**
    * @Rest\View(statusCode=Response::HTTP_CREATED)
    * @Rest\Post("articles")
    */
    public function postArticleAction(Request $request)
    {
        $article = new Article();

        $article->setName($request->get('name'))
                ->setDescription($request->get('description'))
                ->setPrice($request->get('price'))
                ->setImg($request->get('img'))
                ->setMarque($request->get('marque'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return $article;
    }
}
