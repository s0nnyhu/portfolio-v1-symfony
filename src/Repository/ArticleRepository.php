<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function updateStatus($status, $id) {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'UPDATE App\Entity\Article a SET a.isPublic = :status WHERE a.id = :id')
        ->setParameters(array('status'=> $status, 'id'=> $id));
        return $query->execute();
    }
}
