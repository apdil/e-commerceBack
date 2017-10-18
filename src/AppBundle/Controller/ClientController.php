<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Location;
use AppBundle\Entity\Basket;
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
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Post("/client")
     */
    // create relation with one location
    public function postClientAction(Request $request)
    {
        $client = new Client();
        $location = new Location();
        $basket = new Basket();

        $form = $this->createForm(ClientType::class, $client);

        $form->submit($request->request->all()); // Validation des données

        $location->setAdress(0)
                ->setCity(0)
                ->setCodePostale(0)
                ->setTel(0);

        $basket->setPrice(0)
                ->setDelivry(0);

        $client->addLocation($location);
        $client->setBasketParent($basket);
        $basket->setClientParent($client);

        if ($form->isValid()) {        
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
     * @Rest\View(serializerGroups={"client"})
     * @Rest\Put("/client/{id}")
     */
    public function putClientAction($id, Request $request){
        return $this->updateClient($id, $request, true);
    }

    /**
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

        $form = $this->createForm(ClientType::class, $client);

        $form->submit($request->request->all(), $clearMissing);

        if($form->isValid()){
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
}
