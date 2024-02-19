<?php

namespace App\Repository;

use App\Entity\Nem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nem>
 *
 * @method Nem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nem[]    findAll()
 * @method Nem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nem::class);
    }

//    /**
//     * @return Nem[] Returns an array of Nem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Nem
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
