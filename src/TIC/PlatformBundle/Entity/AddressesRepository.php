<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AddressesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressesRepository extends EntityRepository
{
    /**
     * @param $contract
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByContractQuery($contract)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.clientAddresses', 'ca')
            ->leftJoin('ca.client', 'c')
            ->leftJoin('c.contracts', 'cc')
            ->where('cc = :contract')
            ->setParameter('contract', $contract);

        return $qb;
    }

    /**
     * @param Contracts $contract
     * @return Addresses[]
     */
    public function findAllByContractID(Contracts $contract)
    {
        return $this->findByContractQuery($contract)->getQuery()->getResult();
    }
}
