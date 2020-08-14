<?php

namespace TIC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FacturationModeRepository extends EntityRepository
{
    /**
     * @return FacturationMode[]
     */
    public function findAllWithRequiredData()
    {
        $qb = $this->createQueryBuilder('f');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $itemID
     * @return FacturationMode
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithRequiredData($itemID)
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.facturationModeID = :itemID')
            ->setParameter('itemID', $itemID);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $itemID
     * @return FacturationMode
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findForDelete($itemID)
    {
        $qb = $this->createQueryBuilder('f')
//            ->leftJoin('t.trainings', 'tt')
//            ->addSelect('tt')
            ->where('f.facturationModeID = :itemID')
            ->setParameter('itemID', $itemID);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
