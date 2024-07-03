<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonce>
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function findAllAnnonces()
    {
        return $this->findAllOptimize()->getQuery()->getResult();
    }


    public function findAllByOrderDate($field, $order)
    {
        $db = $this->findAllOptimize()->orderBy('a.'.$field, $order);
        return $db->getQuery()->getResult();
    }

    public function findAllByOrderDateQuery($field, $order)
    {
        $db = $this->findAllOptimize()->orderBy('a.'.$field, $order);
        return $db->getQuery();
    }

    public function findAllOptimize()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.agences', 'agences')
            ->addSelect('agences')
            ->leftJoin('a.equipements', 'equipements')
            ->addSelect('equipements')
            ->leftJoin('a.categorie', 'categorie')
            ->addSelect('categorie');
    }

    //    /**
    //     * @return Annonce[] Returns an array of Annonce objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Annonce
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
