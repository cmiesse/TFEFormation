<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TIC\PlatformBundle\Entity\events;
use TIC\PlatformBundle\Helpers\CountDays;
use Tools\CustomBundle\Controller\MasterController;

class PlanningController extends MasterController
{
    public function indexAction()
    {
//        $this->get('tic_platform.google_calendar')->findItem("3k4cfjjmhs8rk2ck50j10mt8h4@group.calendar.google.com");
        $em = $this->getDoctrine()->getManager();
        $trainers = $em->getRepository("TICPlatformBundle:Trainers")->findAll();
        return $this->render('TICPlatformBundle:Plannings:view.html.twig', array(
            'trainers' => $trainers
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $session = $this->em->getRepository('TICPlatformBundle:Sessions')->findOneWithAll($id);

        $this->exceptionIfNull($session);
        return $this->render('TICPlatformBundle:Plannings:view.html.twig', array(
            'session' => $session, 'clientName' => $session->getContract()->getClient()->getClientName(),
            'formationName' => $session->getTraining()->getTrainingName(), 'showAllDefault' => true,
            'formationLanguage' => $session->getLanguage() !== null ? $session->getLanguage()->getLanguage() : null,
            'COUNT' => CountDays::calculDays($session->getEvents()->toArray())
        ));
    }

    /**
     * @param $sessionID
     * @return JsonResponse
     */
    public function getInfoAction($sessionID)
    {
        if ($sessionID == "-1") {
            $events = $this->em->getRepository('TICPlatformBundle:events')->findForPlanning();
        } else {
            $session = $this->em->getRepository('TICPlatformBundle:Sessions')->find($sessionID);
            $this->exceptionIfNull($session);
            $events = $this->em->getRepository('TICPlatformBundle:events')->findForPlanning($session);
        }
        $res = array();
        foreach ($events as $event) {
            array_push($res, $event->toJSON());
        }

        return new JsonResponse($res);
    }

    /**
     * @param Request $request
     * @param $sessionID
     * @return JsonResponse
     */
    public function updateInfoAction(Request $request, $sessionID)
    {
        $responseArray = array();
        $editing = $request->query->get('editing');
        if (!isset($editing) || strcmp($request->query->get('editing'), "true") != 0) {
            throw $this->createAccessDeniedException();
        }
        $ids = explode(",", $request->request->get('ids'));

        $globalSession = $this->em->getRepository('TICPlatformBundle:Sessions')->find($sessionID);
        $NbElem = null;
        if ($globalSession !== null) {
            $elems = $this->em->getRepository('TICPlatformBundle:events')->findBy(array('session' => $globalSession));
            $NbElem = CountDays::calculDays($elems);
        }

        if (count($ids) > 1) {
            throw new BadRequestHttpException();
        }

        $id = $ids[0];
        $status = $request->request->get(sprintf("%s_!nativeeditor_status", $id));
        $eventFromDB = $this->em->getRepository('TICPlatformBundle:events')->find($id);

        $responseArray['type'] = $status;
        $responseArray['sid'] = $id;

        if (strcmp($status, "inserted") == 0) {
            if ($eventFromDB === null) {
                if ($globalSession === null || $globalSession->getSessionNumberOfDays() - $NbElem > 0) {
                    $event = new events();
                    $event->initFromScheduler($id, $request->request);
                    $trainer = $this->em->getRepository('TICPlatformBundle:Trainers')->find($request->request->get(sprintf("%s_TrainerID", $id)));
                    $session = $this->em->getRepository('TICPlatformBundle:Sessions')->findOneForAgenda($request->request->get(sprintf("%s_SessionID", $id)));
                    $event->setTrainer($trainer);
                    $event->setSession($session);
                    $this->em->persist($event);
                    $this->em->flush();
                    $responseArray['tid'] = $event->getId();
                    if ($trainer !== null && $trainer->getTrainerCalendarID() !== null) {
                        $this->get('tic_platform.google_calendar')->insertItem($trainer->getTrainerCalendarID(), $event);
                    }
                    $responseArray['color'] = $event->toJSON()['color'];
                    $responseArray['textColor'] = $event->toJSON()['textColor'];
                }
            }
        } else if (strcmp($status, "updated") == 0) {
            if ($eventFromDB !== null) {
                $events = $globalSession !== null ? $globalSession->getEvents()->toArray() : null;
                if ($events !== null) {
                    unset($events[array_search($eventFromDB, $events)]);
                }
                $oldTrainer = $eventFromDB->getTrainer();
                $eventFromDB->initFromScheduler($id, $request->request);
                $trainer = $this->em->getRepository('TICPlatformBundle:Trainers')->find($request->request->get(sprintf("%s_TrainerID", $id)));
                if ($request->request->get(sprintf("%s_SessionID", $id)) !== null) {
                    $session = $this->em->getRepository('TICPlatformBundle:Sessions')->findOneForAgenda($request->request->get(sprintf("%s_SessionID", $id)));
                    if ($session !== null) {
                        $eventFromDB->setSession($session);
                    }
                }
                $eventFromDB->setTrainer($trainer);

                if ($globalSession !== null) {
                    if ($globalSession->getSessionNumberOfDays() - CountDays::calculDays($events) >= 0){
                        $this->em->flush();
                    } else {
                        $responseArray['type'] = "canceled";
                    }
                } else {
                    $this->em->flush();
                }

                $responseArray['tid'] = $eventFromDB->getId();
                if ($oldTrainer !== $trainer) {
                    if ($oldTrainer !== null && $trainer !== null) {
                        $this->get('tic_platform.google_calendar')->moveItem($oldTrainer->getTrainerCalendarID(), $eventFromDB, $trainer->getTrainerCalendarID());
                    } else if ($oldTrainer !== null && $oldTrainer->getTrainerCalendarID() !== null) {
                        $this->get('tic_platform.google_calendar')->removeItem($oldTrainer->getTrainerCalendarID(), $eventFromDB, true);
                    } else if ($trainer !== null && $trainer->getTrainerCalendarID() !== null) {
                        $this->get('tic_platform.google_calendar')->insertItem($trainer->getTrainerCalendarID(), $eventFromDB);
                    }
                } else if ($trainer !== null && $trainer->getTrainerCalendarID() !== null) {
                    $this->get('tic_platform.google_calendar')->updateItem($trainer->getTrainerCalendarID(), $eventFromDB);
                }
                $responseArray['color'] = $eventFromDB->toJSON()['color'];
                $responseArray['textColor'] = $eventFromDB->toJSON()['textColor'];
            }
        } else if (strcmp($status, "deleted") == 0) {
            if ($eventFromDB !== null) {
                $trainer = $this->em->getRepository('TICPlatformBundle:Trainers')->find($request->request->get(sprintf("%s_TrainerID", $id)));
                $responseArray['tid'] = null;
                $this->em->remove($eventFromDB);
                $this->em->flush();
                if ($trainer !== null && $trainer->getTrainerCalendarID() !== null) {
                    $this->get('tic_platform.google_calendar')->removeItem($trainer->getTrainerCalendarID(), $eventFromDB);
                }
                $responseArray['color'] = null;
                $responseArray['textColor'] = null;
            }
        }

        if ($NbElem !== null && $globalSession !== null) {
            $elems = $this->em->getRepository('TICPlatformBundle:events')->findBy(array('session' => $globalSession));
            $NbElem = CountDays::calculDays($elems);
        }

        return new JsonResponse(array_merge($responseArray, array(
            "COUNT" => $NbElem, "SESSION" => $globalSession !== null
        )));
    }
}
