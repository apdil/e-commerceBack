<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Basket;
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


class BasketController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"basket"})
     * @Rest\Get("/baskets")
     */
    public function getAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $baskets = $em->getRepository('AppBundle:Basket')->findAll();

        return $baskets;
    }

    /**
     * @Rest\View(serializerGroups={"basket"})
     * @Rest\Get("/baskets/{id}")
     */
    public function getBasketAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $basket = $em->getRepository('AppBundle:Basket')->find($id);

        return $basket;
    }

}
