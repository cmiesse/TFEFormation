<?php
/**
 * Created by PhpStorm.
 * User: Dorian
 * Date: 29/04/2016
 * Time: 10:50
 */

namespace TIC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TIC\PlatformBundle\Entity\FacturationMode;

class LoadFacturationMode extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            'Mode 1',
            'Mode 2',
            'Mode 3'
        );

        foreach ($data as $item) {
            $facturation = new FacturationMode();
            $facturation->setFacturationModeLabel($item);
            $manager->persist($facturation);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}


