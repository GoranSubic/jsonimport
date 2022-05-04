<?php

namespace App\Repository;

use App\Entity\Team;
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
                't.teamId as id, t.country, t.alternateName as alternate_name, t.fifaCode as fifa_code, t.groupId as group_id, t.groupLetter as group_letter'
            )
            // ->addSelect('COUNT(wcmwins.winner) as wins')
            ->addSelect('COUNT(wcma.awayTeamCountry) as games_played')

            // ->leftJoin('App\Entity\WorldcupMatch', 'wcmwins', 'WITH', 't.country = wcmwins.winner')
            ->leftJoin('App\Entity\WorldcupMatch', 'wcma', 'WITH', 't.country = wcma.homeTeamCountry OR t.country = wcma.awayTeamCountry', )
            
            ->groupBy('t.teamId')
            ->orderBy('t.teamId', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array Returns an array of wins
     */
    public function findWinsResults()
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(wcmwins.winner) as wins')
            ->leftJoin('App\Entity\WorldcupMatch', 'wcmwins', 'WITH', 't.country = wcmwins.winner')
            
            ->groupBy('t.teamId')
            ->orderBy('t.teamId', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array Returns an array of draws
     */
    public function findDrawsResults()
    {
        return $this->createQueryBuilder('t')
            ->select('t.country, COUNT(wcm.winner) as draws')
            ->leftJoin('App\Entity\WorldcupMatch', 'wcm', 'WITH', 't.country = wcm.homeTeam.country AND wcm.winner = :draw')
            ->setParameter('draw', 'Draw')
            
            ->groupBy('t.teamId')
            ->orderBy('t.teamId', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array Returns an array of away_draws
     */
    public function findAwayDrawsResults()
    {
        return $this->createQueryBuilder('t')
            ->select('t.country, COUNT(wcm.winner) as away_draws')
            ->leftJoin('App\Entity\WorldcupMatch', 'wcm', 'WITH', 't.country = wcm.awayTeam.country AND wcm.winner = :draw')
            ->setParameter('draw', 'Draw')
            
            ->groupBy('t.teamId')
            ->orderBy('t.teamId', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array Returns an array of goals
     */
    public function findHomeGoalsResults()
    {
        return $this->createQueryBuilder('t')
            ->select('SUM(wcmgoals.awayTeam.goals) as goals_against, SUM(wcmgoals.homeTeam.goals) as goals_for')
            ->leftJoin('App\Entity\WorldcupMatch', 'wcmgoals', 'WITH', 't.country = wcmgoals.homeTeam.country')
            
            ->groupBy('t.teamId')
            ->orderBy('t.teamId', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array Returns an array of goals
     */
    public function findAwayGoalsResults()
    {
        return $this->createQueryBuilder('t')
            ->addSelect('SUM(wcmgoalsa.homeTeam.goals) as goals_against, SUM(wcmgoalsa.awayTeam.goals) as goals_for')
            ->leftJoin('App\Entity\WorldcupMatch', 'wcmgoalsa', 'WITH', 't.country = wcmgoalsa.awayTeam.country')
            
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
