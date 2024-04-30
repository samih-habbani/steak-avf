<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function save(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //////////CUSTOM FUNCTION THAT SENDS RELATED QUESTIONS////////////
    public function findRelatedQuestion($idCategory, $idQuestion) {

        return $this->createQueryBuilder('a')
            ->where('a.category = :idCategory')
            ->setParameter('idCategory', $idCategory)
            ->andWhere('a.id <> :idQuestion')
            ->setParameter('idQuestion',$idQuestion)
            ->orderBy('a.likeCount', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCategory($categoryId)
    {
        return $this->createQueryBuilder('q')
            ->join('q.category', 'c')
            ->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->orderBy('q.creationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCategoriesWithQuestions(): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.questions', 'q')
            ->getQuery()
            ->getResult();
    }


    public function findBySearch($search) {

        return $this->createQueryBuilder('a')
            ->where('a.content LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
