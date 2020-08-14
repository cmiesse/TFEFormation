<?php
/**
 * Created by PhpStorm.
 * Date: 23-05-16
 * Time: 11:39
 */

namespace TIC\PlatformBundle\Services;

use Doctrine\ORM\EntityManager;
use TIC\PlatformBundle\Entity\events;
use TIC\PlatformBundle\Google\GoogleCalendar;

class GoogleCalendarService
{
    /**
     * @var GoogleCalendar
     */
    private $calendar;

    /**
     * @var \Google_Service_Calendar
     */
    private $service;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     * GoogleCalendarService constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->calendar = new GoogleCalendar();
        $this->service = new \Google_Service_Calendar($this->calendar->getClient());
        $this->em = $em;
    }

    /**
     * @param $calendarID
     * @param events $event
     */
    public function insertItem($calendarID, events $event)
    {
        $data = $this->getCommonItem($event);
        $res = $this->service->events->insert($calendarID, $data);
        $event->setCalendarEventID($res->getId());
        $this->em->flush();
    }

    /**
     * @param $calendarID
     * @param events $event
     * @param $toCalendarID
     */
    public function moveItem($calendarID, events $event, $toCalendarID)
    {
        if ($calendarID !== null && $toCalendarID !== null) {
            $res = $this->service->events->move($calendarID, $event->getCalendarEventID(), $toCalendarID);
            $event->setCalendarEventID($res->getId());
            $data = $this->getCommonItem($event);
            $this->service->events->update($toCalendarID, $event->getCalendarEventID(), $data);
            $this->em->flush();
        } else {
            if ($calendarID === null && $toCalendarID !== null) {
                // TODO FINISH
            }  else if ($calendarID !== null && $toCalendarID === null) {

            }
        }
    }

    /**
     * @param $calendarID
     * @param events $event
     */
    public function updateItem($calendarID, events $event)
    {
        $data = $this->getCommonItem($event);
        $this->service->events->update($calendarID, $event->getCalendarEventID(), $data);
    }

    /**
     * @param events $event
     * @return \Google_Service_Calendar_Event
     */
    private function getCommonItem(events $event)
    {
        $format = 'Y-m-d\TH:i:sP'; //DATE_ATOM
        $data = new \Google_Service_Calendar_Event();
        $startDate = new \Google_Service_Calendar_EventDateTime();
        $startDate->setDateTime($event->getStartDate()->format($format));
        $data->setStart($startDate);
        $endDate = new \Google_Service_Calendar_EventDateTime();
        $endDate->setDateTime($event->getEndDate()->format($format));
        $data->setEnd($endDate);
        $data->setSummary($event->getText());
        if ($event->getSession() !== null) {
            $data->setLocation($event->getSession()->getAddress()->toAgenda());
        }
        return $data;
    }

    /**
     * @param $calendarID
     * @param events $event
     * @param bool $updateID
     */
    public function removeItem($calendarID, events $event, $updateID = false)
    {
        if ($event->getCalendarEventID() !== null) {
            $this->service->events->delete($calendarID, $event->getCalendarEventID());
            if ($updateID) {
                $event->setCalendarEventID(null);
                $this->em->flush();
            }
        }
    }

    public function clear($calendarID)
    {
        $events = $this->service->events->listEvents($calendarID);
        foreach ($events->getItems() as $item) {
            $this->service->events->delete($calendarID, $item['id']);
        }
    }

    public function findItem($calendarID, $eventID = "6gu1eofj8casf8s6gks8njbohk")
    {
        dump($this->service->events->get($calendarID, $eventID));
        die;
    }
}