<?php

namespace App\Repository;

use App\Entity\ClassRoutine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClassRoutine>
 *
 * @method ClassRoutine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassRoutine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassRoutine[]    findAll()
 * @method ClassRoutine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassRoutineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassRoutine::class);
    }

//    /**
//     * @return ClassRoutine[] Returns an array of ClassRoutine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClassRoutine
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
