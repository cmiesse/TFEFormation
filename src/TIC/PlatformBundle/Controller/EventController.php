<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository("TICPlatformBundle:events")->findAllWithAll();
        $i = 0;
        foreach($events as $event)
        {
            $res[$i] = $event->toArray();
            $i++;
        }

        return new JsonResponse($res);
    }

}
