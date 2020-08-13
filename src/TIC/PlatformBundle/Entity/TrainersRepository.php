<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrainersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrainersRepository extends EntityRepository
{
    /**
     * @param $trainerID
     * @return Trainers
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findForDelete($trainerID)
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.sessions', 's')
            ->addSelect('s')
            ->leftJoin('t.documentCv', 'dcv')
            ->addSelect('dcv')
            ->leftJoin('t.documentsIdentityCard', 'dic')
            ->addSelect('dic')
            ->where('t.id = :trainerID')
            ->setParameter('trainerID', $trainerID);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllActiveQuery()
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.trainerActive = TRUE');

        return $qb;
    }

    /**
     * @param $trainerID
     * @return Trainers
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithAll($trainerID)
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.address', 'a')
            ->addSelect('a')
            ->leftJoin('a.countries', 'ac')
            ->addSelect('ac')
            ->leftJoin('a.clientAddresses', 'ca')
            ->addSelect('ca')
            ->leftJoin('t.Country', 'c')
            ->addSelect('c')
            ->leftJoin('t.languages', 'l')
            ->addSelect('l')
            ->where('t.id = :trainerID')
            ->leftJoin('t.documentCv', 'dcv')
            ->addSelect('dcv')
            ->leftJoin('t.documentsIdentityCard', 'dic')
            ->addSelect('dic')
            ->setParameter('trainerID', $trainerID);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $trainerID
     * @return Trainers
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithAllEvent($trainerID)
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.events', 'e')
            ->addSelect('e')
            ->where('t.id = :trainerID')
            ->setParameter('trainerID', $trainerID);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return Trainers[]
     */
    public function findAllWithEvents()
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.events', 'e')
            ->addSelect('e');

        return $qb->getQuery()->getResult();
    }
}
