<?php

namespace Afup\SubscriptionBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Afup\SubscriptionBundle\Entity\Corporation;
use Afup\UserBundle\Entity\User;

/**
 * CorporateSubscriptionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CorporateSubscriptionRepository extends EntityRepository
{
    /**
     * Return the current Subscription
     * @param Corporation $corporation
     * @return Subscription
     */
    public function getCurrentSubscription(Corporation $corporation){
        
        $date = new \DateTime();
        
        return $this->createQueryBuilder('s')
            ->where('s.corporation = :corporation')
            ->andWhere('s.dateStart <= :date')
            ->andWhere('s.dateEnd >= :date')
            ->setParameter('corporation', $corporation)
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
     * Return the current Subscription
     * @param User $user
     * @return Subscription
     */
    public function getCurrentSubscriptionWithUser(User $user){
        return $this->getCurrentSubscription($user->getCorporation());
    }

    /**
     * Return the last Subscription
     * @param Corporation $corporation
     * @return Subscription
     */
    public function getLastSubscription(Corporation $corporation){
        
        $date = new \DateTime();
        
        return $this->createQueryBuilder('s')
            ->where('s.corporation = :corporation')
            ->addOrderBy('s.dateStart', 'DESC')
            ->setParameter('corporation', $corporation)
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
     * Return the current Subscription
     * @param User $user
     * @return Subscription
     */
    public function getLastSubscriptionWithUser(User $user){
        return $this->getLastSubscription($user->getCorporation());
    }
}