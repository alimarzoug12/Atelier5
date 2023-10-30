<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBookByName($name)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.author', 'a')
            ->where('a.username=:username')
            ->andWhere('b.publishedDate>:publishedDate')
            ->setParameter('username', 'Mohsen')
            ->setParemeters(['username'=>'sami','publishedDtae'=>'2023-10-30'])
            ->orderBy('b.title', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function searchBookByRef($ref)
    {
        return $this->createQueryBuilder('b')
            ->where('b.ref=:ref')
            ->setParameter('ref',$ref)
            ->getQuery()
            ->getResult();
    }

    public function booksListByAuthors($name)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.author', 'a')
            ->where('a.username=:username')
            ->setParameter(['username'=>$name])
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
}

    public function editBooksCategory()
    {
        return $this->createQueryBuilder('b')
            ->update('App:Book', 'b')
            ->set('b.cxategory', ':newCategory')
            ->where('b.category=:oldCategory')
            ->setParameter('newCategory', 'Romance')
            ->setParameter('oldCategory', 'Science-Fiction')
            ->getQuery()
            ->execute();

}

    public function deleteBooksByRef($ref)
    {
        return $this->createQueryBuilder('b')
            ->delete('App:Book', 'b')
            ->where('b.ref=:ref')
            ->setParameter('ref', $ref)
            ->getQuery()
            ->execute();
    }



//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
