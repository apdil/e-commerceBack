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
     * @Rest\View()
     * @Rest\Get("/preparateur")
     */
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();

        $preparateurs = $em->getRepository('AppBundle:Preparateur')->findAll();

        return $preparateurs;
    }

    /**
     * @Rest\View()
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
}
