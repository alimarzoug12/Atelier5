<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    function listAuthorByEmail($email)
    {
        return $this->createQueryBuilder('a')
            ->oredrBy('a.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    function searchAuthorDQL($min, $max)
    {
        $em=$this->getEntityManager();
        return $em->createQuery('SELECT a from App\Entity\Author a where a.nb_books between ?1 and ?2')
            ->setParameter(1,$min)
            ->setParameter(2,$max)
            ->getResult();
    }

    function searchAuthorDQLByFirstCaracterName()
    {
        $em=$this->getEntityManager();
        return $em->createQuery('SELECT count(a) from App\Author a where a.nb_books > 0')
            ->getSingleScalarResult();
    }

//    /**
//     * @return Author[] Returns an array of Author objects
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

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
