<?php

namespace App\Repository;

use App\Entity\EventWay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventWay|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventWay|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventWay[]    findAll()
 * @method EventWay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventWayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventWay::class);
    }

    //получить все направления мироприятий
    public function get_events_way(){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM event_way
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();

    }


    //получить напрпаление по id
    public function get_event_way_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM event_way
      WHERE id = :id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);
      return $stmt->fetchAll()[0];

    }


    //получить все актуальные направления мироприятий
    public function get_active_events_way(){
      $dateNow = date('Y-m-d H:i:s');

      $conn = $this->getEntityManager()->getConnection();
      //Выбираем уникальные актуальные направления
      $sql = '
      SELECT DISTINCT event_way
      FROM events
      WHERE event_end_time >= :dateNow
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'dateNow'=>$dateNow
      ]);
      $answer = $stmt->fetchAll();



      //Далее мы производим отчистку и фильтрацию информации с последующим созданием коллекции и ее возвратом
      $ways_arr = [];

      for ($i=0; $i < count($answer); $i++) {

        $clear_data = str_replace('"', '' , $answer[$i]['event_way']);
        $clear_data = str_replace('[', '' , $clear_data);
        $clear_data = str_replace(']', '' , $clear_data);
        $clear_data = str_replace(' ', '' , $clear_data);


        if(strpos($clear_data,',') !== FALSE){
           $clear_data_arr = explode(',',$clear_data);

        for ($z=0; $z < count($clear_data_arr); $z++) {

          if(!in_array($clear_data_arr[$z], $ways_arr)){
            $tmp_data = $this->get_event_way_by_id($clear_data_arr[$z]);
            $ways_arr[] = $tmp_data;
          }

        }

      } else {
        if(!in_array($clear_data, $ways_arr)){
        $tmp_data = $this->get_event_way_by_id($clear_data);
        $ways_arr[] = $tmp_data;
      }
      }




      }


      return $ways_arr;

    }


    //получить актуальные направления мироприятий пользователя
    public function get_user_active_events_way($user_id){
      $dateNow = date('Y-m-d H:i:s');

      $conn = $this->getEntityManager()->getConnection();
      //Выбираем уникальные актуальные направления
      $sql = '
      SELECT DISTINCT event_way
      FROM events
      WHERE event_end_time >= :dateNow AND user_id = :user_id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'dateNow'=>$dateNow,
        'user_id'=>$user_id
      ]);
      $answer = $stmt->fetchAll();

      //Далее мы производим отчистку и фильтрацию информации с последующим созданием коллекции и ее возвратом
      $ways_arr = [];

      for ($i=0; $i < count($answer); $i++) {

        $clear_data = str_replace('"', '' , $answer[$i]['event_way']);
        $clear_data = str_replace('[', '' , $clear_data);
        $clear_data = str_replace(']', '' , $clear_data);
        $clear_data = str_replace(' ', '' , $clear_data);


        if(strpos($clear_data,',') !== FALSE){
           $clear_data_arr = explode(',',$clear_data);

        for ($z=0; $z < count($clear_data_arr); $z++) {

          if(!in_array($clear_data_arr[$z], $ways_arr)){
            $tmp_data = $this->get_event_way_by_id($clear_data_arr[$z]);
            $ways_arr[] = $tmp_data;
          }

        }

      } else {
        if(!in_array($clear_data, $ways_arr)){
        $tmp_data = $this->get_event_way_by_id($clear_data);
        $ways_arr[] = $tmp_data;
      }
      }

      }


      return $ways_arr;

    }
}
