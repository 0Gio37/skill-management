<?php

namespace App\Repository;

use App\Entity\LienUserSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LienUserSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method LienUserSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method LienUserSkill[]    findAll()
 * @method LienUserSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LienUserSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LienUserSkill::class);
    }

    // /**
    //  * @return LienUserSkill[] Returns an array of LienUserSkill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LienUserSkill
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
