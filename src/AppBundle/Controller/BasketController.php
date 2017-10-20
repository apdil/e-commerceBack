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
     * @Rest\Get("/basket/{id}")
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $baskets = $em->getRepository('AppBundle:Basket')->findAll();

        return $baskets;
    }

}
