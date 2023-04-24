<?php

namespace App\Repository;

use App\Data\SearchAdvance;
use App\Data\SearchData;
use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 *
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    public function add(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function findDistinctType(): array
    {
        return $this->createQueryBuilder('f')
                    ->select('f.type')->distinct()
                   ->getQuery()
                   ->getResult()
                ;
    }
    /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function findDistinctThematique(): array
    {
        return $this->createQueryBuilder('f')
                    ->select('f.thematique')->distinct()
                   ->getQuery()
                   ->getResult()
                ;
    }

    /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function finFormationType(): array
    {
        return $this->createQueryBuilder('f')
                    ->select('f.thematique', 'count(f.id) as count')
                    ->groupBy('f.thematique')
                    ->orderBy('f.thematique','ASC')
                    ->getQuery()
                    ->getResult()
                ;
    }


    /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function findDistinctLangue(): array
    {
        return $this->createQueryBuilder('f')
                    ->select('f.langue')->distinct()
                   ->getQuery()
                   ->getResult()
                ;
    }

    /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function findSearch(SearchData $searchData): array
    {
      $query = $this
      ->createQueryBuilder('f');
      
      if(!empty($searchData->q)){
        $query->andwhere('f.title LIKE :q')
        ->setParameter('q',"%{$searchData->q}%");
      }
      if(!empty($searchData->type)){
        $query->andwhere('f.type LIKE :p')
        ->setParameter('p',"%{$searchData->type}%");
      }
      if(!empty($searchData->thematique)){
        $query->andwhere('f.thematique LIKE :m')
        ->setParameter('m',"%{$searchData->thematique}%");
      }
      if(!empty($searchData->langue)){
        $query->andwhere('f.langue LIKE :l')
        ->setParameter('l',"%{$searchData->langue}%");
      }
      $query->orderBy('f.id', 'DESC');
      
      return $query->getQuery()->getResult();
    }

    /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function findSearchAdvance(SearchAdvance $searchavance): array
    {
      

      $query = $this
      ->createQueryBuilder('f');
      
      if(!empty($searchavance->q)){
        $query->andwhere('f.title LIKE :q')
        ->setParameter('q',"%{$searchavance->q}%");
      }
      if(!empty($searchavance->type)){
        $query->andwhere('f.type IN  (:p)')
        ->setParameter('p',$searchavance->type);
      }
      if(!empty($searchavance->thematique)){
        $query->andwhere('f.thematique IN  (:m)')
        ->setParameter('m',$searchavance->thematique);
      }
      if(!empty($searchavance->langue)){
        $query->andwhere('f.langue IN  (:l)')
        ->setParameter('l',$searchavance->langue);
      }
      if(!empty($searchavance->partenaire)){
        $query->andwhere('f.partenaire IN  (:n)')
        ->setParameter('n',$searchavance->partenaire);
      }
      if(!empty($searchavance->date_start)){
        $query->andwhere('f.date_start >= :t0')
        ->setParameter('t0',$searchavance->date_start);
      }
      if(!empty($searchavance->date_end)){
        $query->andwhere('f.date_end <= :t1')
        ->setParameter('t1',$searchavance->date_end);
      }
      if(!empty($searchavance->date_ins_d)){
        $query->andwhere('f.dateInsD >= :t2')
        ->setParameter('t2',$searchavance->date_ins_d);
      }
      if(!empty($searchavance->date_ins_f)){
        $query->andwhere('f.DateInsF <= :t3')
        ->setParameter('t3',$searchavance->date_ins_f);
      }
      $query->orderBy('f.id', 'DESC');
      
      return $query->getQuery()->getResult();
    }

   
     /**
     * @return Formation[] Returns an array of Formation objects 
     */
    public function findSearchh(SearchData $searchData): array
    {
      $query = $this
      ->createQueryBuilder('f');
      
      if(!empty($searchData->q)){
        $query->andwhere('f.title LIKE :q')
        ->setParameter('q',"%{$searchData->q}%");
      }
      if(!empty($searchData->type)){
        $query->andwhere('f.type LIKE :p')
        ->setParameter('p',"%{$searchData->type}%");
      }
      if(!empty($searchData->thematique)){
        $query->andwhere('f.thematique LIKE :m')
        ->setParameter('m',"%{$searchData->thematique}%");
      }
      if(!empty($searchData->langue)){
        $query->andwhere('f.langue LIKE :l')
        ->setParameter('l',"%{$searchData->langue}%");
      }
      $query->orderBy('f.id', 'DESC');
      $query->setMaxResults(6);
      
      return $query->getQuery()->getResult();
    }

    /**
     * @return Formation[] Returns an array of Formation objects
     */
    public function getNombreFormt(): array
    {
        return $this->createQueryBuilder('f')
            ->select('count(f.id)')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getNombreThem(): array
    {
        return $this->createQueryBuilder('f')
            ->select('count(f.id)')
            ->groupBy('f.thematique')
            ->getQuery()
            ->getResult()
        ;
    }
}
