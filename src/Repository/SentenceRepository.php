<?php

namespace App\Repository;

use App\Entity\Acte;
use App\Entity\Sentence;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Sentence>
 *
 * @method Sentence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sentence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sentence[]    findAll()
 * @method Sentence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sentence::class);
    }

    public function save(Sentence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sentence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countStep(Acte $acte)
    {
        return $this->createQueryBuilder('s')
        ->select('count(s.step)')
        ->join('s.acte', 'a')
        ->where('a.id = :acte_id')
        ->setParameters(['acte_id' => $acte])
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return Sentence[] Returns an array of Sentence objects
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

//    public function findOneBySomeField($value): ?Sentence
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
