<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
    public function findCurrentSessionHomePage(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('s')
            ->andWhere(':today >= s.dateDebut')
            ->andWhere(':today <= s.dateFin')
            ->orderBy('s.dateFin', 'ASC')
            ->setMaxResults(2)
            ->setParameter('today', $now)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastSessionHomePage(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateFin < :today')
            ->orderBy('s.dateFin', 'ASC')
            ->setMaxResults(2)
            ->setParameter('today', $now)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNextSessionHomePage(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut > :today')
            ->orderBy('s.dateDebut', 'ASC')
            ->setMaxResults(2)
            ->setParameter('today', $now)
            ->getQuery()
            ->getResult()
        ;
    }

public function findCurrentSessionSessionPage(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('s')
            ->andWhere(':today >= s.dateDebut')
            ->andWhere(':today <= s.dateFin')
            ->orderBy('s.dateFin', 'ASC')
            ->setParameter('today', $now)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastSessionSessionPage(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateFin < :today')
            ->orderBy('s.dateFin', 'ASC')
            ->setParameter('today', $now)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNextSessionSessionPage(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut > :today')
            ->orderBy('s.dateDebut', 'ASC')
            ->setParameter('today', $now)
            ->getQuery()
            ->getResult()
        ;
    }
}
