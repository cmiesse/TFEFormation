<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TIC\PlatformBundle\Entity\events;
use TIC\PlatformBundle\Entity\Sessions;
use TIC\PlatformBundle\Form\SessionsSearchType;
use TIC\PlatformBundle\Form\SessionsType;
use Tools\CustomBundle\Controller\MasterController;

class SessionController extends MasterController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new SessionsSearchType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $sessions = $this->em->getRepository('TICPlatformBundle:Sessions')->findSessionByParam($form->getData());
        } else {
            $sessions = $this->em->getRepository("TICPlatformBundle:Sessions")->findSessionByParam(null);
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->translator->trans('session.list'));

        return $this->render('TICPlatformBundle:Sessions:view.html.twig', array(
            'sessions' => $sessions,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $session = new Sessions();

        $form = $this->createForm(new SessionsType(), $session);
        $form = $form->handleRequest($request);

        $this->setAddress($request, $session);
        
        if ($request->isMethod('POST') && $this->get('validator')->validate($session) && $session->isDatesValid()) {
            $this->em->persist($session);
            $this->em->flush();

            return $this->redirectToRoute('tic_platform_sessions_edit_planning', array('id' => $session->getId()));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('session.list'), 'tic_platform_sessions');
        $breadcrumbs->addItem($this->translator->trans('session.new'));

        return $this->render('TICPlatformBundle:Sessions:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $session = $this->em->getRepository('TICPlatformBundle:Sessions')->findOneWithAll($id);

        $this->exceptionIfNull($session);

        $form = $this->createForm(new SessionsType(), $session);
        $form->handleRequest($request);

        $this->setAddress($request, $session);

        if ($request->isMethod('POST') && $this->get('validator')->validate($session) && $session->isDatesValid()) {
            $this->em->flush();
            return $this->redirectToRoute('tic_platform_sessions_edit_planning', array('id' => $session->getId()));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('session.list'), 'tic_platform_sessions');
        $breadcrumbs->addItem($this->translator->trans('session.edit'));

        return $this->render('TICPlatformBundle:Sessions:edit.html.twig', array(
            'form' => $form->createView(),
            'session' => $session
        ));
    }

    private function setAddress(Request $request, Sessions $sessions)
    {
        $formData = $request->request->get('tic_platformbundle_sessions');
        if ($request->isMethod('POST') &&  $formData !== null) {
            if (array_key_exists('address', $formData)) {
                $sessions->setAddress($this->em->getRepository("TICPlatformBundle:Addresses")->find($formData['address']));
            }
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $session = $this->em->getRepository('TICPlatformBundle:Sessions')->findForDelete($id);

        $this->exceptionIfNull($session);

        $googleService = $this->get('tic_platform.google_calendar');
        /** @var events $event */
        foreach ($session->getEvents() as $event) {
            if ($event->getTrainer() !== null && $event->getTrainer()->getTrainerCalendarID() && $event->getCalendarEventID() !== null) {
                $googleService->removeItem($event->getTrainer()->getTrainerCalendarID(), $event);
            }
        }

        $this->em->remove($session);
        $this->em->flush();

        return $this->redirect($this->generateUrl('tic_platform_sessions'));
    }

    /**
     * @param Request $request
     * @param $contractID
     * @return JsonResponse
     */
    public function getAddressesAction(Request $request, $contractID)
    {
        $this->RejectNonXHR($request);

        $contract = $this->em->getRepository('TICPlatformBundle:Contracts')->find($contractID);

        $this->exceptionIfNull($contract);

        $addresses = $this->em->getRepository('TICPlatformBundle:Addresses')->findAllByContractID($contract);
        
        $res = array();

        foreach ($addresses as $address) {
            array_push($res, $address->toJSON());
        }

        return new JsonResponse(array(
            "addresses" => $res,
            "dailyAmount" => $contract->getContractDailyAmount()
        ));
    }
}
