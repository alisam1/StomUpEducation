<?php

namespace App\Repository;

use App\Entity\MainAd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainAd|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainAd|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainAd[]    findAll()
 * @method MainAd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainAdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainAd::class);
    }

    //Получаем все рекламы
    public function get_ads(){
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM main_ad
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }


    //Возвращаем рекламу по имени блока
    public function get_ad_by_key($block_name){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM main_ad
      WHERE block_name = :block_name
      ORDER BY id DESC
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['block_name'=>$block_name]);
      return $stmt->fetchAll();

    }

    public function update_ad_by_key($block_name,$img,$link,$css){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE main_ad
      SET img = :img, link = :link, css = :css
      WHERE block_name = :block_name
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'img'=>$img,
        'link'=>$link,
        'css'=>$css,
        'block_name'=>$block_name
      ]);

      return 'ok';

    }


}
