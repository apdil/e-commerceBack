<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Basket;
use AppBundle\Entity\Client;
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



class CommandeController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"commande"})
     * @Rest\Get("/commandes/basket/{id}")
     */
    public function getCommandesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('AppBundle:Commande')->find($id);

        return $commandes->getClient();
    }

    /**
     * @Rest\View(serializerGroups={"commande"})
     * @Rest\Get("/commande/basket/{basket_id}/validate")
     */
    public function getValidBasketAction($basket_id)
    {
        $em = $this->getDoctrine()->getManager();
        $basket = $em->getRepository('AppBundle:Basket')->find($basket_id);
        // get by dependances
        $articles = $basket->getArticles();
        $client = $basket->getClientParent();
        
        $commande = new Commande();

        // push articles in commande
        foreach($articles as $article){
            $commande->addArticle($article);
            $basket->removeArticle($article);
        }

        $commande->setClient($client);
        $client->addCommande($commande);

        $em->persist($commande);
        $em->flush();

        return $commande;
    }

    /**
     * @Rest\View(serializerGroups={"commande"})
     * @Rest\Get("/commande/{id}")
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $basket = $em->getRepository('AppBundle:Basket')->find($basket_id);
        // get by dependances
        $articles = $basket->getArticles();
        $client = $basket->getClientParent();
        
        $commande = new Commande();

        // push articles in commande
        foreach($articles as $article){
            $commande->addArticle($article);
            $basket->removeArticle($article);
        }

        $commande->setClient($client);
        $client->addCommande($commande);

        $em->persist($commande);
        $em->flush();

        return $commande;
    }
}
