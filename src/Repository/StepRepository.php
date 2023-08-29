<?php

namespace App\Repository;

use App\Entity\Step;
use App\Entity\Trip;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @extends ServiceEntityRepository<Step>
 *
 * @method Step|null find($id, $lockMode = null, $lockVersion = null)
 * @method Step|null findOneBy(array $criteria, array $orderBy = null)
 * @method Step[]    findAll()
 * @method Step[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Step::class);
    }

    public function add(Step $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Step $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findStepsFromTrip()
    {
        $sql = "SELECT *  
        FROM `step`
        WHERE `trip_id`= 2";

        $conn = $this->getEntityManager()->getConnection();
        $result = $conn->executeQuery($sql)->fetchAllAssociative();

        return ($result);
    }

    /**
     * Get castings for a given movie
     */
    //public function findAllTest(Trip $trip)
    //{
    //    $entityManager = $this->getEntityManager();

    //    $query = $entityManager->createQuery(
    //        'SELECT s, 
    //        FROM App\Entity\Step AS s
    //        WHERE s.trip = :trip'
    //    )->setParameter('trip', $trip);
//
    //    // returns an array of Step objects
    //    return $query->getResult();
    //}


//    /**
//     * @return Step[] Returns an array of Step objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Step
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
