<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Preparateur;
use AppBundle\Form\PreparateurType;
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


class PreparateurController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"preparateur"})
     * @Rest\Get("/preparateur")
     */
    public function getAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $preparateurs = $em->getRepository('AppBundle:Preparateur')->findAll();

        return $preparateurs;
    }

    /**
     * @Rest\View(serializerGroups={"preparateur"})
     * @Rest\Get("/preparateur/{id}")
     */
    public function getPreparateurAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $preparateur = $em->getRepository('AppBundle:Preparateur')->find($id);

        return $preparateur;
    }

    /**
     * create preparateur
     * @Rest\View(serializerGroups={"preparateur"})
     * @Rest\Post("/preparateur")
     */
    public function postAction(Request $request)
    {
        $preparateur = new Preparateur();

        $form = $this->createForm(PreparateurType::class, $preparateur);

        $form->submit($request->request->all());

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preparateur);
            $em->flush();
            return $preparateur;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(serializerGroups={"preparateur"})
     * @Rest\Get("/preparateur/{preparateur_id}/commande/{commande_id}")
     */
    public function getCheckAction($preparateur_id, $commande_id){

        $em = $this->getDoctrine()->getManager();

        $preparateur = $em->getRepository('AppBundle:Preparateur')->find($preparateur_id);
        $commande = $em->getRepository('AppBundle:Commande')->find($commande_id);

        $preparateur->addCommande($commande);
        $commande->addPreparateur($preparateur);
        $commande->setTreatment(true);

        $em->flush();

        return $preparateur;

    }

    /**
     * @Rest\View(serializerGroups={"preparateur"})
     * @Rest\Get("/preparateur/{preparateur_id}/commande/{commande_id}/delivred")
     */
    public function getDelivredAction($preparateur_id, $commande_id){
        
                $em = $this->getDoctrine()->getManager();
        
                $preparateur = $em->getRepository('AppBundle:Preparateur')->find($preparateur_id);
                $commande = $em->getRepository('AppBundle:Commande')->find($commande_id);
        
                $commande->setInDelivring(true);
        
                $em->flush();
        
                return $preparateur;
        
            }
}
