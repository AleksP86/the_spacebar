<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getAllStories()
    {
        return $this->createQueryBuilder('a')
                ->orderBy('a.publishedAt','DESC')
                ->getQuery()
                ->getResult();
    }

    public function getStoryBySlug($value)
    {
        return $this->createQueryBuilder('a')
                ->andWhere('a.slug=:val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getResult();
    }

    public function countArticles()
    {
        $conn=$this->getEntityManager()->getConnection();
        $sql='SELECT count(id) as \'counted\' from article WHERE id>:id';
        $stmt=$conn->prepare($sql);
        $stmt->execute(['id'=>0]);

        return $stmt->fetchAll();

        return $this->createQueryBuilder('a')
                ->andWhere('a.exampleField = :val')
                ->setParameter('val', $value)
                ->orderBy('a.id','ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
