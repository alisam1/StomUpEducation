<?php

namespace App\Repository;

use App\Entity\SitesReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SitesReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method SitesReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method SitesReview[]    findAll()
 * @method SitesReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SitesReview::class);
    }

    //Создаем новый отзыв
    public function make_new_review($site_id,$reviewer_name,$reviewer_worker_position,$reviewer_text){

      $em = $this->getEntityManager();

       $review = new SitesReview();
       $review->setSiteId($site_id);
       $review->setReviewerName($reviewer_name);
       $review->setReviewerWorkerPosition($reviewer_worker_position);
       $review->setReviewerText($reviewer_text);

       // скажите Doctrine, что вы (в итоге) хотите сохранить (пока без запросов)
       $em->persist($review);

       // на самом деле выполнить запросы (т.е. запрос INSERT)
       $em->flush();

       return 'ok';

    }

    //Получаем все отзывы по id сайта
    public function get_data_by_site($site_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
        SELECT *
        FROM sites_review
        WHERE site_id = :site_id
        ORDER BY id DESC
        ';
        //
        $stmt = $conn->prepare($sql);
        $stmt->execute(['site_id'=>$site_id]);

        $answr = $stmt->fetchAll();

        return $answr;

    }

    //Получаем один отзыв по id сайта
    public function get_one_data_by_site($site_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
        SELECT *
        FROM sites_review
        WHERE site_id = :site_id
        ORDER BY id DESC
        LIMIT 1
        ';
        //
        $stmt = $conn->prepare($sql);
        $stmt->execute(['site_id'=>$site_id]);

        $answr = $stmt->fetchAll();

        return $answr;

    }

    //Удаляем отзыв
    public function delete_review_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      DELETE
      FROM sites_review
      WHERE id = :id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);

      return 'ok';
    }




}
