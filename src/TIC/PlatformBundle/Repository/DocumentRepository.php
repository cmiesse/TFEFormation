<?php

namespace TIC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TIC\PlatformBundle\Entity\Document;

class DocumentRepository extends EntityRepository
{
    /**
     * @param $trainerID
     * @param $documentID
     * @return Document
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneForDelete($trainerID, $documentID)
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.trainer', 't')
            ->leftJoin('d.trainerCV', 'tcv')
            ->where('d.documentID = :documentID')
            ->andWhere('(t.id = :trainerID OR tcv.id = :trainerID)')
            ->setParameters(array(
                'documentID' => $documentID,
                'trainerID' => $trainerID
            ));

        return $qb->getQuery()->getOneOrNullResult();
    }
}