<?php

namespace App\Repository;

use App\Entity\Pdfs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pdfs>
 *
 * @method Pdfs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pdfs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pdfs[]    findAll()
 * @method Pdfs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdfsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pdfs::class);
    }

//    /**
//     * @return Pdfs[] Returns an array of Pdfs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pdfs
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
