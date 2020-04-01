<?php

namespace App\Repository;

use App\Entity\MainBanners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainBanners|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainBanners|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainBanners[]    findAll()
 * @method MainBanners[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainBannersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainBanners::class);
    }

    //Создаем новый баннер
    public function create_banner(){

      $em = $this->getEntityManager();

       $banner = new MainBanners();
       $banner->setImg('image');

       // скажите Doctrine, что вы (в итоге) хотите сохранить (пока без запросов)
       $em->persist($banner);

       // на самом деле выполнить запросы (т.е. запрос INSERT)
       $em->flush();

       return 'ok';
    }


    //Получаем все баннеры
    public function get_banners(){
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM main_banners
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    //Возвращаем баннеры по id
    public function get_banner_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM main_banners
      WHERE id = :id
      ORDER BY id DESC
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);
      return $stmt->fetchAll();

    }


    //Обновляем баннер
    public function update_banner($banner_id,$banner_zag,$banner_link,$banner_descr,$banner_btn_text,$photo_banner,$banner_priority){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE main_banners
      SET img = :photo_banner, text_h = :banner_zag, link = :banner_link, description = :banner_descr, btn_text = :banner_btn_text, priority = :banner_priority 
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
        'banner_id'=>$banner_id,
        'banner_priority'=>$banner_priority
      ]);

      return 'ok';
    }


    //Удаляем баннер
    public function delete_banner_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      DELETE
      FROM main_banners
      WHERE id = :id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);

      return 'ok';
    }



}
