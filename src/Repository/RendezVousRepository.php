<?php

namespace App\Repository;

use App\Entity\RendezVous;
use App\Entity\PropertySearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<RendezVous>
 *
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    public function add(RendezVous $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RendezVous $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RendezVous[] Returns an array of RendezVous objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RendezVous
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findServiceRDV($users)
    {
        $service = $users->getSpecialite();
        $qb = $this->createQueryBuilder('r')
                    ->where('r.service = :service')
                    ->setParameter('service', $service);
        // dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getArrayResult();
    }
    public function findAllRdvSecretary() 
    {
        $qb = $this->createQueryBuilder('r');
    return $qb->getQuery()->getArrayResult();
    }

    public function findAllRdv() 
        {
            $qb = $this->createQueryBuilder('r')
                        ->select('COUNT(r)');
        return $qb->getQuery()->getSingleScalarResult();
        }

        public function countAllRdvByDate() 
    {
        $today = date("Y-n-j");
        $qb = $this->createQueryBuilder('r')
                    ->Where('r.date_rdv = :date_rdv')
                    ->setParameter('date_rdv', $today)
                    ->select('COUNT(r)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countAllRdvByStatus() 
    {
        $qb = $this->createQueryBuilder('r')
                    ->andWhere('r.status = :status')
                    ->setParameter('status', 'A Venir')
                    ->select('COUNT(r)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findRdv($users) 
    {
        $service = $users->getSpecialite();
        $qb = $this->createQueryBuilder('r')
                    ->where('r.service = :service')
                    ->setParameter('service', $service)
                    ->select('COUNT(r)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countRdvByStatus($users) 
    {
        $service = $users->getSpecialite();
        // dump($service);
        $qb = $this->createQueryBuilder('r')
                    ->where('r.service = :service')
                    ->setParameter('service', $service)
                    ->andWhere('r.status = :status')
                    ->setParameter('status', 'A Venir')
                    ->select('COUNT(r)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countRdvByDate($users) 
    {
        $service = $users->getSpecialite();
        $today = date("Y-n-j");
        // dump($today);
        $qb = $this->createQueryBuilder('r')
                    ->where('r.service = :service')
                    ->setParameter('service', $service)
                    ->andWhere('r.date_rdv = :date_rdv')
                    ->setParameter('date_rdv', $today)
                    ->select('COUNT(r)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findUserRdv($users, PropertySearch $search) 
    {
        $mail = $users->getEmail();
        $qb = $this->createQueryBuilder('r')
                    ->where('r.email_patient = :email_patient')
                    ->setParameter('email_patient', $mail);
        if($search->getService()){
                    $qb->andWhere('r.service = :service')
                       ->setParameter('service',$search->getService());
        }
                    
            // dump($qb->getQuery()->getResult());

        return $qb->getQuery()->getArrayResult();
    }

}
