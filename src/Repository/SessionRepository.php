<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
        return $this->createQueryBuilder('s')
            ->andWhere('CURDATE() BETWEEN s.date_debut AND s.date_fin')
            ->orderBy('s.date_fin', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastSessionHomePage(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_fin < CURDATE()')
            ->orderBy('s.date_fin', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNextSessionHomePage(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_debut > CURDATE()')
            ->orderBy('s.date_debut', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
        ;
    }

public function findCurrentSessionSessionPage(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('CURDATE() BETWEEN s.date_debut AND s.date_fin')
            ->orderBy('s.date_fin', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastSessionSessionPage(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_fin < CURDATE()')
            ->orderBy('s.date_fin', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNextSessionSessionPage(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_debut > CURDATE()')
            ->orderBy('s.date_debut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
