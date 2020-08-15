<?php

namespace TIC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TIC\PlatformBundle\Entity\PerformancesTypes;

class LoadPerformanceTypes extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $Types = array(
            'Training',
            'TrainingDesign',
            'Coaching',
            'Blended learning',
            'Logical support person',
            'Consultancy',
            'Service or support',
            'Test and certification'
        );

        foreach ($Types as $Type)
        {
            $Performance = new PerformancesTypes();
            $Performance->setPerformanceType($Type);

            $manager->persist($Performance);
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
        return 3;
    }
}


