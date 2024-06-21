<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findProductsSearched(?Category $category,?string $keywords): array
    {
        $query= $this->createQueryBuilder('p')
        ->select('c','p')
        ->join('p.category', 'ca');

        if ( ! empty($category))
        {
            $query = $query
                ->andWhere('c.id IN((: Category)')
                ->setParameter('category', $category);
        }

        if ( ! empty($keywords))
        {
            $query = $query
                ->andWhere('LOWER(p.name) LIKE :keywordsSearched OR lOWER(p.description)')
                ->setParameter('keywordsSearched', '%'.mb_strtolower($keywords)).'%';
        }

        return $query->getQuery()->getResult();
    }

 
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

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}
