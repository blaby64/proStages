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

     /**
      * @return Stage[] Returns an array of Stage objects
      */

    public function findByEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
            ->Where('e.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nomEntreprise)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Stage[] Returns an array of Stage objects
     */

    public function findByFormation($nomFormation)
    {
      $gestionnaireEntite = $this->getEntityManager();
      $requete = $gestionnaireEntite->createQuery(
        'SELECT s, e, f
        FROM App\Entity\Stage s
        JOIN s.formations f
        JOIN s.entreprise e
        WHERE f.nom = :nomFormation');
        $requete->setParameter('nomFormation',$nomFormation);
        return $requete->execute();
    }

    /**
     * @return Stage[] Returns an array of Stage objects
     */

     public function findAllStages()
     {
       $gestionnaireEntite = $this->getEntityManager();
       $requete = $gestionnaireEntite->createQuery(
         'SELECT s, e, f
         FROM App\Entity\Stage s
         JOIN s.formations f
         JOIN s.entreprise e');
         return $requete->execute();
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
