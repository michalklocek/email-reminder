<?php

use Doctrine\ORM\EntityRepository;

class ReminderRepository extends EntityRepository
{
    public function findToSend()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT r FROM Reminder r
                WHERE r.sent = 0 AND r.sendAt <= :now'
            )->setParameter('now', new \DateTime());

        return $query->getResult();
    }
} 