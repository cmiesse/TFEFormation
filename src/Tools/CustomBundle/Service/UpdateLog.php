<?php

namespace Tools\CustomBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Tools\CustomBundle\Entity\Log;
use Tools\CustomBundle\Interfaces\LogInterface;

class UpdateLog
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var Session
     */
    private $session;

    public function __construct(TokenStorage $tokenStorage, Session $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof LogInterface) {
            $data = $args->getEntityChangeSet();
            if (count($data) > 0) {
                $em = $args->getEntityManager();
                $token = $this->tokenStorage->getToken();
                $email = isset($token) ? $token->getUser()->getEmail() : 'localhost';
                $Logs = array();
                foreach ($data as $field => $items) {
                    $Log = new Log();
                    $Log->setLogTable($args->getEntityManager()->getClassMetadata(get_class($entity))->getTableName());
                    $Log->setLogEmail($email);
                    $Log->setLogField($field);
                    $Log->setLogOldValue($this->setData($items[0], $em));
                    $Log->setLogNewValue($this->setData($items[1], $em));
                    array_push($Logs, $Log);
                }
                $this->session->set('Logs' , $Logs);
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $Logs = $this->session->get('Logs');
        if (isset($Logs) && !empty($Logs) && $args->getEntity() instanceof LogInterface) {
            $em = $args->getEntityManager();
            foreach ($Logs as $log) {
                $em->persist($log);
            }
            $em->flush();
            $this->session->remove('Logs');
        }
    }

    /**
     * @param $data
     * @param EntityManager $em
     * @return string
     */
    private function setData($data, EntityManager $em)
    {
        if ($data instanceof \DateTime) {
            return $data->format('d-m-Y H:i:s');
        } else if (is_object($data)) {
            $methodName = sprintf("get%s", ucfirst($em->getClassMetadata(get_class($data))->getIdentifier()[0]));
            return (string)$data->$methodName();
        }
        return $data;
    }
}