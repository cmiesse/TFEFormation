<?php
namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TIC\PlatformBundle\Entity\events;
use TIC\PlatformBundle\Entity\Trainers;
use Tools\CustomBundle\Controller\MasterController;

class WebmasterController extends MasterController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $users = $this->em->getRepository('TICUserBundle:User')->findAll();
        
        return $this->render('TICPlatformBundle:webmaster:index.html.twig', array(
            'users' => $users
        ));
    }

    public function resetCalendarAction(Request $request)
    {
        $trainers = $this->em->getRepository('TICPlatformBundle:Trainers')->findAllWithEvents();

        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('resetAll', 'submit', array(
            'attr' => array('class' => 'btn btn-primary')
        ));
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($trainers as $trainer) {
                $this->resetOneCalendarAction($request, $trainer, true);
            }
        }

        return $this->render('TICPlatformBundle:webmaster:calendar.html.twig', array(
            'trainers' => $trainers, 'form' => $form->createView()
        ));
    }

    public function resetOneCalendarAction(Request $request, $trainerID, $withObject = false)
    {
        if ($withObject && $trainerID instanceof Trainers) {
            $trainer = $trainerID;
        } else {
            $this->RejectNonXHR($request);
            $trainer = $this->em->getRepository('TICPlatformBundle:Trainers')->findOneWithAllEvent($trainerID);
        }
        
        $this->exceptionIfNull($trainer);
        if ($trainer->getTrainerCalendarID() === null) {
            return new Response();
        }

        $calendar = $this->get('tic_platform.google_calendar');

        $calendar->clear($trainer->getTrainerCalendarID());

        /** @var events $event */
        foreach ($trainer->getEvents() as $event) {
            $calendar->insertItem($trainer->getTrainerCalendarID(), $event);
        }

        return new Response('Valid');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleValidateFormAction()
    {
        $session = $this->get('session');
        if (null === $session->get('validate_form')) {
            $session->set('validate_form', true);
        } else {
            $session->remove('validate_form');
        }
        return $this->redirectToRoute('tic_platform_main_dispatch');
    }
}