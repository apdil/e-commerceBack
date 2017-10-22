<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Location;
use AppBundle\Entity\Basket;
use AppBundle\Entity\Commande;
use AppBundle\Form\ClientType;
use AppBundle\Form\LocationType;
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


class ClientController extends Controller
{
    /**
     * get all client
     * 
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Get("/clients")
     */
    public function getClientsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('AppBundle:Client')->findAll();

        return $clients;
    }

    /**
     * get one client
     * 
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Get("/client/{id}")
     */
    public function getClientAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('AppBundle:Client')->find($id);

        if (empty($client)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $client;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"client"})
     * @Rest\Post("/client")
     */
    public function postClientAction(Request $request)
    {
        $client = new Client();
        $location = new Location();
        $basket = new Basket();

        $form = $this->createForm(ClientType::class, $client, ['validation_groups'=>['Default', 'New']]);

        $form->submit($request->request->all()); // Validation des données

        $client->addLocation($location);
        $client->setBasketParent($basket);
        $basket->setClientParent($client);

        if ($form->isValid()) { 
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPlainPassword());
            $client->setPassword($encoded);
            
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($client);
            $em->persist($location);
            $em->persist($basket);
            $em->flush();
            return $client;
        } else {
            return $form;
        }
    }

    /**
     * update all properties
     * 
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Put("/client/{id}")
     */
    public function putClientAction($id, Request $request){
        return $this->updateClient($id, $request, true);
    }

    /**
     * update some properties
     * 
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Patch("/client/{id}")
     */
    public function patchClientAction($id, Request $request){
        return $this->updateClient($id, $request, false);
    }
    

    private function updateClient($id, Request $request, $clearMissing){

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($id);

        if (empty($client)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(ClientType::class, $client, $options);

        $form->submit($request->request->all(), $clearMissing);

        
        if($form->isValid()){
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $em->merge($client);
            $em->flush();
            return $client;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/client/{id}")
     */
    public function deleteClientAction($id){

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($id);

        if (empty($client)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $location = $client->getLocation();

        if($client){
            $em->remove($client);
            $em->remove($location);
            $em->flush();
        }
    }
    
    /**
     * add article in basket of client
     * 
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Get("/client/{client_id}/basket/article/{article_id}")
     */
    public function getBasketArticleAction($client_id, $article_id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($client_id);
        $article = $em->getRepository('AppBundle:Article')->find($article_id);

        if (empty($client) || empty($article)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $basket = $client->getBasketParent();

        $basket->addArticle($article);
        $article->addBasket($basket);

        $em->flush();

        return $client;
    }

    /**
     * delete article of basket of client
     * 
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"client"})
     * @Rest\Delete("/client/{client_id}/basket/article/{article_id}")
     */
    public function deleteBasketArticleAction($client_id, $article_id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($client_id);
        $article = $em->getRepository('AppBundle:Article')->find($article_id);

        if (empty($client) || empty($article)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $basket = $client->getBasketParent();

        $basket->removeArticle($article);
        $article->removeBasket($basket);
        $em->flush();

        return $basket;
    }

    /**
     * clien valid basket
     * transfer articles and client in commande && remove basket
     * 
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Get("/client/{client_id}/basket/commande")
     */
    public function getBasketCommandeAction($client_id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($client_id);
        // get by dependances of basket

        $basket = $client->getBasketParent();
        $articles = $basket->getArticles();
        
        $commande = new Commande();

        // push articles in commande
        foreach($articles as $article){
            $commande->addArticle($article);
            $basket->removeArticle($article);
            $article->removeBasket($basket);            
        }

        $commande->setClient($client);
        $client->addCommande($commande);

        $em->persist($commande);
        $em->flush();

        return $commande;
    }
}
