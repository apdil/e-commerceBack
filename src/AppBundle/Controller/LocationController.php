<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Entity\Client;
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

class LocationController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"location"})
     * @Rest\Get("/locations")
     */
    public function getLocationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('AppBundle:Location')->findAll();

        return $locations;
    }

    /**
     * @Rest\View(serializerGroups={"location"})
     * @Rest\Get("/location/{id}")
     */
    public function getLocationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $location = $em->getRepository('AppBundle:Location')->find($id);

        return $location;
    }

    /**
     * add more location to client
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"location"})
     * @Rest\Post("/location/client/{client_id}")
     */
    public function postLocationAction(Request $request, $client_id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($client_id);

        if (empty($client)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        
        $location = new Location();

        $form = $this->createForm(LocationType::class, $location);

        $form->submit($request->request->all()); // Validation des données

        $client->addLocation($location);

        if ($form->isValid()) {        
            $em->persist($client);
            $em->persist($location);
            $em->flush();
            return $location;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/location/{id}")
     */
    public function deleteLocationAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository('AppBundle:Location')->find($id);
        
        if (empty($location)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
                
        if($location){
           $em->remove($location);
           $em->flush();
        }
    }
}
