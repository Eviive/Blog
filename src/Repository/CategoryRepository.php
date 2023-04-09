<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Category[] Returns the first 10 categories ordered by the number of posts and then by name
     */
    public function findPopularCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->leftJoin('c.posts', 'p')
            ->groupBy('c.id')
            ->having('COUNT(p.id) > 0')
            ->addOrderBy('COUNT(p.id)', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findAllNotEmptyAndPostsCount(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'COUNT(p.id) AS postCount')
            ->leftJoin('c.posts', 'p')
            ->groupBy('c.id')
            ->having('COUNT(p.id) > 0')
            ->addOrderBy('COUNT(p.id)', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAndCountPosts(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'COUNT(p.id) AS postCount')
            ->leftJoin('c.posts', 'p')
            ->groupBy('c.id')
            ->addOrderBy('COUNT(p.id)', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Category[] Returns an array of Category objects
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

//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
