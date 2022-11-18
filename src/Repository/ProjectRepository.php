<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function save(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int|null $last
     * @return Project[]
     */
    public function filter(?int $last = null): array
    {
        $queryBuilder = $this->createQueryBuilder('project');
        $queryBuilder->orderBy('project.id', 'DESC');

        if ($last) {
            $queryBuilder->setMaxResults($last);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    public function countProjects()
    {
        return $this->createQueryBuilder('project')
            ->select('COUNT(project.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function queryTest()
    {
        $queryBuilder = $this->createQueryBuilder('project');

        $queryBuilder
            ->orderBy('project.id', 'DESC')
            ->where('project.theme = 1');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

//    public function teste()
//    {
//        $query = $this->getEntityManager()->createQuery(
//            'SELECT COUNT(p.id) FROM App\Entity\Project p'
//        );
//
//        return $query->getSingleScalarResult();
//    }

//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
