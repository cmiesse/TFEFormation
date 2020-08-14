<?php

namespace TIC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TIC\PlatformBundle\Entity\Editor;

class EmployerRepository extends EntityRepository
{
    /**
     * @return Editor[]
     */
    public function findAllWithRequiredData()
    {
        $qb = $this->createQueryBuilder('e');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $itemID
     * @return Editor
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithRequiredData($itemID)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.employerID = :itemID')
            ->setParameter('itemID', $itemID);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $itemID
     * @return Editor
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findForDelete($itemID)
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.trainers', 't')
            ->addSelect('t')
            ->where('e.employerID = :itemID')
            ->setParameter('itemID', $itemID);
            
        return $qb->getQuery()->getOneOrNullResult();
    }
}