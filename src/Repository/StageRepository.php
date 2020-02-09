<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }
    
    public function fetchByNomEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('STAGE')
            ->join('STAGE.entreprise','ENTREPRISE')
            ->where('ENTREPRISE.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nomEntreprise)
            ->orderBy('STAGE.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function fetchByFormation($formation)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT STAGE
            FROM App\Entity\Stage STAGE
            JOIN STAGE.formations FORMATION
            WHERE FORMATION.id = :idFormation')
            ->setParameter('idFormation', $formation)
            ->execute();
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
