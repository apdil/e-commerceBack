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

/**
 * Client controller.
 *
 * @Route("client")
 */
class ClientController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/clients")
     */
    public function getClientsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('AppBundle:Client')->findAll();

        return $clients;
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
}
