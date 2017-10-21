<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
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


class CategorieController extends Controller
{

    /**
     * return articles by categorie
     * 
     * @Rest\View(serializerGroups={"categorie"})
     * @Rest\Get("categorie/{id}/articles")
     */
    public function getArticlesCategorieAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categorie')->find($id);

        if (empty($categorie)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $categorie;
    }
}
