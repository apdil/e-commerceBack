<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Location;
use AppBundle\Form\ClientType;
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

        if (empty($clients)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

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
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $client;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/client")
     */
    public function postClientAction(Request $request)
    {
        $client = new Client();
        $location = new Location();

        $form = $this->createForm(ClientType::class, $client);

        $form->submit($request->request->all()); // Validation des données

        $location->setAdress(0)
                ->setCity(0)
                ->setCodePostale(0)
                ->setTel(0);

        $client->setLocation($location);

        if ($form->isValid()) {        
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($client);
            $em->persist($location);
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

        $location = $client->getLocation();

        if($client){
            $em->remove($client);
            $em->remove($location);
            $em->flush();
        }
    }
}
