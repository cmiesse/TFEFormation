<?php

namespace TIC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TIC\PlatformBundle\Entity\Tools;

class LoadTools extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ToolsName = array(
            'Word',
            'Excel',
            'Visual Studio',
            'AlgoBot',
            'Eclipse',
            'Android Studio',
            'MySQL WorkBench',
            'Photoshop'
        );

        foreach ($ToolsName as $ToolName)
        {
            $Tool = new Tools();
            $Tool->setToolName($ToolName);

            $manager->persist($Tool);
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
        return 4;
    }
}


