<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inscription>
 *
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

    public function add(Inscription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Inscription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
	
	 /**
     * @return Inscription[] Returns an array of Inscription objects
     */
    public function getNombreInscrit(): array
    {
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getNombreInscritMal(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.genre , count(i.id) as total')
            ->groupBy('i.genre')
            
            ->andWhere('i.genre LIKE :v')
            ->setParameter('v', 'Homme')
            ->getQuery()
            ->getResult()
        ;
    }
    public function getNombreInscritfemal(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.genre , count(i.id) as total')
            ->groupBy('i.genre')
          
            ->andWhere('i.genre LIKE :v')
            ->setParameter('v', 'Femme')
            ->getQuery()
            ->getResult()
        ;
    }

    public function finInscFonction(): array
    {
        return $this->createQueryBuilder('i')
                    ->select('i.poste', 'count(i.id) as count')
                    ->groupBy('i.poste')
                    ->orderBy('i.poste','ASC')
                    ->getQuery()
                    ->getResult()
                ;
    }
    public function finInscGouvern(): array
    {
        return $this->createQueryBuilder('i')
                    ->select('i.gouvernorat')->distinct()
                    ->orderBy('i.gouvernorat','ASC')
                  
                    ->getQuery()
                    ->getResult()
                ;
    }
    public function finInscSexeH($gov): array
    {
        return $this->createQueryBuilder('i')
                    ->select('i.gouvernorat', 'count(i.id) as count')
                    ->groupBy('i.gouvernorat')
                    ->orderBy('i.gouvernorat','ASC')
                    ->andWhere('i.genre = :val')
                    ->setParameter('val', 'Homme')
                    ->andWhere('i.gouvernorat = :gov')
                    ->setParameter('gov', $gov)
                    ->getQuery()
                    ->getResult()
                ;
    }
    public function finInscSexeF($gov): array
    {
        return $this->createQueryBuilder('i')
                    ->select('i.gouvernorat', 'count(i.id) as count')
                    ->groupBy('i.gouvernorat')
                    ->andWhere('i.genre = :val')
                    ->setParameter('val', 'Femme')
                    ->andWhere('i.gouvernorat = :gov')
                    ->setParameter('gov', $gov)
                    ->getQuery()
                    ->getResult()
                ;
    }
    /**
     * @return Inscription[] Returns an array of Inscription objects
     */
    public function findInscriptStatus(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.gouvernorat', 'count(i.id) as count')
            ->groupBy('i.gouvernorat')
            ->orderBy('i.gouvernorat','ASC')
            ->getQuery()
            ->getResult()
        ;
    }
        
    public function findInscriptStatusAcc(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.gouvernorat', 'count(i.id) as count')
            ->groupBy('i.gouvernorat')
            ->orderBy('i.gouvernorat','ASC')
            
            ->getQuery()
            ->getResult()
        ;
    }

   public function getMesFormations($value): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.idUser = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
	
	    
    public function getMesCounts($value): array
    {
        return $this->createQueryBuilder('i')
             ->select('count(i.id)')
            ->andWhere('i.idUser = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getMesCountsAtt($value): array
    {
        return $this->createQueryBuilder('i')
             ->select('count(i.id)')
            ->andWhere('i.idUser = :val')
            ->setParameter('val', $value)
         
            ->getQuery()
            ->getResult()
        ;
    }
    public function getMesCountsAcc($value): array
    {
        return $this->createQueryBuilder('i')
             ->select('count(i.id)')
            ->andWhere('i.idUser = :val')
            ->setParameter('val', $value)
         
            ->getQuery()
            ->getResult()
        ;
    }
	
	
//    /**
//     * @return Inscription[] Returns an array of Inscription objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Inscription
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
