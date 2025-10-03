<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //Query methods
    public function get(): array {
        return $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\Genre','g')
            ->innerJoin('App\Entity\Author','a')
            ->getQuery()
            ->getResult();
    }
    public function getOne(int $id): mixed {
        return $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\Genre','g')
            ->innerJoin('App\Entity\Author','a')
            ->where('b.id = :id')
            ->setParameter("id",$id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
