<?php

namespace TIC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TIC\UserBundle\Entity\User;


class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('admin', 'admin', array('ROLE_ADMIN'), false),
            array('user', 'user', array('ROLE_USER'), false),
            array('sa@bstorm.be', 'Test1234', array(), true)
        );

        foreach($data as $info) {
            $user = new User();
            $user->setInitData($info[0], $info[1]);
            $user->setRoles($info[2]);
            $user->setSuperAdmin($info[3]);
            $user->setEnabled(true);
            $manager->persist($user);
        }
        $manager->flush();
    }
}

