<?php

namespace App\Repository;

use App\Entity\Messanger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Messanger>
 *
 * @method Messanger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messanger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messanger[]    findAll()
 * @method Messanger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessangerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messanger::class);
    }

    public function add(Messanger $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Messanger $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Messanger[] Returns an array of Messanger objects
     */
    public function findComments($user,$id): array
    {
        return $this->createQueryBuilder('m')
            ->Where('m.contacter = :to AND m.sender = :val')
            ->orWhere('m.contacter = :val AND m.sender = :to')
            
            ->setParameter('val', $id)
            ->setParameter('to', $user)
            ->orderBy('m.dateAdd', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Messanger[] Returns an array of Messanger objects
     */
    public function findCommentsrec($user): array
    {
        return $this->createQueryBuilder('m')
            ->Where('m.contacter = :to')
            ->setParameter('to', $user)
            ->orderBy('m.dateAdd', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    
//    public function findOneBySomeField($value): ?Messanger
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
