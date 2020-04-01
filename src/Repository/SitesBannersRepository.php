<?php

namespace App\Repository;

use App\Entity\SitesBanners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SitesBanners|null find($id, $lockMode = null, $lockVersion = null)
 * @method SitesBanners|null findOneBy(array $criteria, array $orderBy = null)
 * @method SitesBanners[]    findAll()
 * @method SitesBanners[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesBannersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SitesBanners::class);
    }

    //Создаем новый баннер
    public function create_banner($site_id){

      $em = $this->getEntityManager();

       $banner = new SitesBanners();
       $banner->setImg('image');
       $banner->setSiteId($site_id);

       // скажите Doctrine, что вы (в итоге) хотите сохранить (пока без запросов)
       $em->persist($banner);

       // на самом деле выполнить запросы (т.е. запрос INSERT)
       $em->flush();

       return 'ok';
    }

    //Возвращаем баннеры по id сайта
    public function get_banners_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM sites_banners
      WHERE site_id = :id
      ORDER BY id DESC
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);
      return $stmt->fetchAll();

    }

    //Удаляем баннер
    public function delete_banner_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      DELETE
      FROM sites_banners
      WHERE id = :id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);

      return 'ok';
    }


    //Обновляем баннер
    public function update_banner($banner_id,$banner_zag,$banner_link,$banner_descr,$banner_btn_text,$photo_banner){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE sites_banners
      SET img = :photo_banner, text_h = :banner_zag, link = :banner_link, description = :banner_descr, btn_text = :banner_btn_text
      WHERE id = :banner_id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'photo_banner'=>$photo_banner,
        'banner_zag'=>$banner_zag,
        'banner_link'=>$banner_link,
        'banner_descr'=>$banner_descr,
        'banner_btn_text'=>$banner_btn_text,
        'banner_id'=>$banner_id
      ]);

      return 'ok';
    }


}
