<?php

namespace TIC\PlatformBundle\Helpers;

use TIC\PlatformBundle\Entity\events;

class CountDays
{
    /**
     * @param events[] $events
     * @return float
     */
    public static function calculDays($events)
    {
        $numberOfDays = 0;
        /** @var events $event */
        foreach ($events as $event) {
            $interval = $event->getEndDate()->diff($event->getStartDate());
            if ($interval->days == 0) {
                if ($interval->h < 4 || ($interval->h == 4 && $interval->i == 0)) {
                    $numberOfDays += 0.5;
                } else {
                    $numberOfDays++;
                }
            } else {
                $numberOfDays += (int)($interval->days * 8 + $interval->h)/8;
            }
        }
        return $numberOfDays;
    }
}