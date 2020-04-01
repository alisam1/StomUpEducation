<?php

namespace App\Repository;

use App\Entity\Sites;
use App\Entity\SitesInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sites[]    findAll()
 * @method Sites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sites::class);
    }


    //Создаем новый сайт
    // TODO: Пулл параметров
    public function create_site($user_id, $site_url , $site_phone, $site_email, $map_cord, $site_seo_title, $site_seo_description, $site_seo_ya, $site_seo_ga, $site_logo, $site_name, $site_station, $site_worktime,$site_city, $site_addr, $site_about_text, $photo_about){
      $em = $this->getEntityManager();

      //Заполняем основную таблицу
      $site = new Sites();
      $site->setSiteUrl($site_url);
      $site->setSitePhone($site_phone);
      $site->setSiteEmail($site_email);
      $site->setSiteMap($map_cord);
      $site->setSiteMetaTitle($site_seo_title);
      $site->setSiteMetaDescription($site_seo_description);
      $site->setSiteAnaliticsYa($site_seo_ya);
      $site->setSiteAnaliticsGa($site_seo_ga);
      $site->setUserId($user_id);
      $site->setSiteMainLogo($site_logo);

      $em->persist($site);
      $em->flush();

      //Заполняем таблицу информации
      $siteInfo = new SitesInfo();
      $siteInfo->setUserId($user_id);
      $siteInfo->setSiteInfoName($site_name);
      $siteInfo->setSiteInfoStation($site_station);
      $siteInfo->setSiteInfoWorktime($site_worktime);
      $siteInfo->setSiteInfoStreet($site_addr);
      $siteInfo->setSiteInfoAbout($site_about_text);
      $siteInfo->setSiteInfoLogo($photo_about);
      $siteInfo->setSiteInfoCity($site_city);

      $em->persist($siteInfo);
      $em->flush();


      return 'ok';
    }


    //Проверяем существует ли сайт под данным пользователем
    public function is_site_exist($user_id){

            $conn = $this->getEntityManager()->getConnection();

            $sql = '
            SELECT id
            FROM sites
            WHERE user_id = :user_id
            ';
            //
            $stmt = $conn->prepare($sql);
            $stmt->execute(['user_id'=>$user_id]);

            $answr = $stmt->fetchAll();

            if(count($answr) > 0){
              return $answr[0]['id'];
            } else {
              return FALSE;
            }


    }



    //Собрать данные по сайту пользователя
    public function get_site_data($user_id){

            $conn = $this->getEntityManager()->getConnection();

            $sql = '
            SELECT *
            FROM sites
            JOIN sites_info ON sites_info.user_id=sites.user_id
            WHERE sites.user_id = :user_id
            ';
            //
            $stmt = $conn->prepare($sql);
            $stmt->execute(['user_id'=>$user_id]);
            $site_data = $stmt->fetchAll();

            return $site_data;
    }

    //Найти сайт по domain
    public function get_site_by_domain($domain){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM sites
      JOIN sites_info ON sites_info.user_id=sites.user_id
      WHERE sites.site_url = :domain
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['domain'=>$domain]);
      $site_data = $stmt->fetchAll();

      return $site_data;
    }


    //Редактировать данные по сайту пользователя
    // TODO: пулл переменных + написать SQL
    public function update_site_data($user_id, $site_url , $site_phone, $site_email, $map_cord, $site_seo_title, $site_seo_description, $site_seo_ya, $site_seo_ga, $site_logo, $site_name, $site_station, $site_worktime,$site_city , $site_addr, $site_about_text, $photo_about){

            $conn = $this->getEntityManager()->getConnection();

            $sql = '
            UPDATE sites
            SET site_url = :site_url, site_phone = :site_phone, site_email = :site_email,
            site_map = :site_map, site_meta_title = :site_meta_title, site_meta_description = :site_meta_description,
            site_analitics_ya = :site_analitics_ya, site_analitics_ga = :site_analitics_ga, site_main_logo = :site_main_logo
            WHERE user_id = :user_id
            ';
            //
            $stmt = $conn->prepare($sql);
            $stmt->execute(
              [
                'user_id'=>$user_id,
                'site_url'=>$site_url,
                'site_phone'=>$site_phone,
                'site_email'=>$site_email,
                'site_map'=>$map_cord,
                'site_meta_title'=>$site_seo_title,
                'site_meta_description'=>$site_seo_description,
                'site_analitics_ya'=>$site_seo_ya,
                'site_analitics_ga'=>$site_seo_ga,
                'site_main_logo'=>$site_logo
              ]
            );

            $sql = '
            UPDATE sites_info
            SET site_info_name = :site_name, site_info_station = :site_station, site_info_worktime = :site_worktime,
            site_info_street = :site_addr, site_info_about = :site_about_text, site_info_logo = :photo_about, site_info_city = :site_city
            WHERE user_id = :user_id
            ';
            //
            $stmt = $conn->prepare($sql);
            $stmt->execute(
              [
                'user_id'=>$user_id,
                'site_name'=>$site_name,
                'site_station'=>$site_station,
                'site_worktime'=>$site_worktime,
                'site_addr'=>$site_addr,
                'site_about_text'=>$site_about_text,
                'photo_about'=>$photo_about,
                'site_city'=>$site_city
              ]
            );

            return 'ok';


    }


    //Получить полный список всех созданных сайтов
    public function get_all_sites(){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM sites
      JOIN sites_info ON sites_info.user_id=sites.user_id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $site_data = $stmt->fetchAll();

      return $site_data;

    }



}
