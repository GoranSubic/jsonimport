<?php

namespace App\Repository;

use App\Entity\Team;
use App\Entity\WorldcupMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Team $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Team $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * @return Team[] Returns an array of Team objects
     */
    public function findTeamResults()
    {
        return $this->createQueryBuilder('t')
            ->select(
                't.teamId as id, t.country, t.alternateName, t.fifaCode, t.groupId, t.groupLetter'
            )
            ->addSelect('COUNT(wcmwins.winner) as wins')
            // ->addSelect('COUNT(wcma.awayTeamCountry) as games_played')

            ->leftJoin('App\Entity\WorldcupMatch', 'wcmwins', 'WITH', 't.country = wcmwins.winner')
            // ->leftJoin('App\Entity\WorldcupMatch', 'wcma', 'WITH', 't.country = wcma.homeTeamCountry OR t.country = wcma.awayTeamCountry', )
            
            ->groupBy('t.teamId')
            ->orderBy('t.teamId', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Team[] Returns an array of Team objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
