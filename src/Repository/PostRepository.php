<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findMostRecentPost(): Post | null
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt is not NULL')
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    public function findOrderedByCommentsCount(int $except): Query
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt is not NULL')
            ->andWhere('p.id != :except')
            ->addOrderBy('p.createdAt', 'DESC')
            ->setParameter('except', $except)
            ->getQuery()
        ;
    }

    public function findPagination(): Query
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt is not NULL')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
        ;
    }

    public function findBySearch(mixed $search): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt is not NULL')
            ->orderBy('LEVENSHTEIN(p.title,:search)', 'ASC')
            ->setParameter('search', $search)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Post[] Returns an array of Post objects
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

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
