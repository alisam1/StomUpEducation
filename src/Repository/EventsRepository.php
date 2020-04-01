<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    //Проверяем мироприятие
    public function check_event($event_name){

      $conn = $this->getEntityManager()->getConnection();
      //Если есть такое имя и ивент еще не закончился - возвращаем имя
      $sql = '
      SELECT event_name
      FROM events
      WHERE event_name = :event_name AND event_end_time > DATE(NOW())
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['event_name'=>$event_name]);
      return $stmt->fetchAll();

    }

    //создание мироприятия
    public function create_event(
      $user_id,$event_name,$event_type,
      $event_way,$event_address, $event_city ,
      $events_datetime_start,$events_datetime_finish,
      $lectors_id,$events_photo,$events_description,
      $is_free,$event_price,$event_discount,$event_discount_percent, $event_points_val,
      $event_sertificate,$event_main_img
      )
      {

        $em = $this->getEntityManager();

        //Преобразуем переменные даты
        $event_start_time = new \DateTime('@'.strtotime($events_datetime_start));
        $event_end_time = new \DateTime('@'.strtotime($events_datetime_finish));

        $event = new Events();
        $event->setUserId($user_id);
        $event->setEventName($event_name);
        $event->setEventType($event_type);
        $event->setEventWay($event_way);
        $event->setEventCity($event_city);
        $event->setEventAddress($event_address);
        $event->setEventStartTime($event_start_time);
        $event->setEventEndTime($event_end_time);
        $event->setLectorId($lectors_id);
        $event->setEventPhotos($events_photo);
        $event->setEventDescription($events_description);
        $event->setIsFree($is_free);
        $event->setPrice($event_price);
        $event->setIsDiscount($event_discount);
        $event->setRulePoint($event_points_val);
        $event->setRuleSertificate($event_sertificate);
        $event->setEventMainImg($event_main_img);
        $event->setEventDiscountPercent($event_discount_percent);

        $em->persist($event);

        $em->flush();

      }

      //Обновление мероприятия
      public function update_event($event_id,$event_name,$event_type,$event_way,$event_city,$event_address, $events_datetime_start, $events_datetime_finish, $lectors_id, $events_description, $event_price, $is_free, $event_points_val, $event_sertificate, $event_main_img ){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE events
        SET event_name = :event_name, event_type = :event_type, event_way = :event_way, event_address = :event_address, event_start_time = :event_start_time, event_end_time = :event_end_time, lector_id = :lector_id, event_description = :event_description, is_free = :is_free, price = :price, rule_point = :rule_point, rule_sertificate = :rule_sertificate, event_main_img = :event_main_img, event_city = :event_city
        WHERE id = :event_id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
          'event_id'=>$event_id,
          'event_name'=>$event_name,
          'event_type'=>$event_type,
          'event_way'=>$event_way,
          'event_address'=>$event_address,
          'event_start_time'=>$events_datetime_start,
          'event_end_time'=>$events_datetime_finish,
          'lector_id'=>$lectors_id,
          'event_description'=>$events_description,
          'is_free'=>$is_free,
          'price'=>$event_price,
          'rule_point'=>$event_points_val,
          'rule_sertificate'=>$event_sertificate,
          'event_main_img'=>$event_main_img,
          'event_city'=>$event_city
        ]);

        return 'ok';

      }

      //получить все мироприятия пользователя
      public function get_user_events($user_id){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *
        FROM events
        WHERE user_id = :user_id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id'=>$user_id]);
        return $stmt->fetchAll();

      }

      //Получаем event по id
      public function get_event_by_id($id){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position 
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE events.id = :id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return $stmt->fetchAll();

      }


      //Тут нужно будет описать подгрузку всех типов мироприятий
      public function get_events_type(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *
        FROM event_type
        ';
        //
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
      }


      //Получаем все города среди активных events
      public function get_events_city(){
        $conn = $this->getEntityManager()->getConnection();
        $dateNow = date('Y-m-d H:i:s');

        $sql = '
        SELECT DISTINCT event_city
        FROM events
        WHERE event_end_time >= :dateNow
        ';
        //
        $stmt = $conn->prepare($sql);
        $stmt->execute(['dateNow'=>$dateNow]);
        return $stmt->fetchAll();
      }

      //Получить event_type по id
      public function get_event_type_by_id($id){

      }

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

      //Получить event_way по id
      public function get_event_way_by_id($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *
        FROM event_way
        WHERE id = :id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return $stmt->fetchAll();
      }

      //получить все мироприятия
      public function get_all_events(){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE event_end_time >= :nowDate
        ORDER BY events.id DESC
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute([ 'nowDate' => $nowDate ]);
        return $stmt->fetchAll();

      }


      //получить последние 4 мероприятия
      public function get_last_four_events(){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE event_end_time >= :nowDate
        ORDER BY events.id DESC
        LIMIT 4
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute([ 'nowDate' => $nowDate ]);
        return $stmt->fetchAll();

      }

      //получить последние мероприятия
      public function get_last_limit_events($limit = 1){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE event_end_time >= :nowDate
        ORDER BY events.id DESC
        LIMIT '.$limit.'
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute([ 'nowDate' => $nowDate ]);
        return $stmt->fetchAll();

      }

      //получение всех мироприятий пользователя
      public function get_my_events($user_id){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE user_id = :user_id AND event_end_time >= :nowDate
        ORDER BY events.id DESC
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'nowDate' => $nowDate]);
        return $stmt->fetchAll();

      }

      //получение всех мироприятий слушателей
      public function get_my_invited_events($user_id){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM event_request
        JOIN events ON event_request.event_id = events.id
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE event_request.user_id = :user_id AND events.event_end_time >= :nowDate
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'nowDate' => $nowDate]);
        return $stmt->fetchAll();

      }

      //получение лимит мироприятий пользователя
      public function get_my_events_limit($user_id, $limit ){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE user_id = :user_id AND event_end_time >= :nowDate
        ORDER BY events.id DESC
        LIMIT '.$limit.'
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'nowDate' => $nowDate]);
        // dd($stmt->fetchAll());
        return $stmt->fetchAll();

      }


      //получение поисковых events пользователя
      public function get_my_events_like($user_id, $like){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE user_id = :user_id AND event_name LIKE :like OR way_name LIKE :like OR type_name LIKE :like
        ORDER BY events.id DESC
        ';

        $like = '%'.$like.'%';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'like' => $like ]);
        return $stmt->fetchAll();

      }


      //получение поисковых events пользователя
      public function get_events_like($like){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE event_name LIKE :like OR way_name LIKE :like OR type_name LIKE :like
        ORDER BY events.id DESC
        ';

        $like = '%'.$like.'%';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['like' => $like ]);
        return $stmt->fetchAll();

      }


      //получение фильтрованные ивенты пользователя
      public function get_my_events_fill($user_id,$params){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE user_id = :user_id
        ';

        $placeholder_arr = [
          'user_id' => $user_id,
        ];

        if(isset($params['event_ways'])){
          $testInt = explode(',',$params['event_ways'])[0];
          if(is_numeric($testInt)){
          $sql .= 'AND event_way.id IN ('.$params["event_ways"].') ';
          }
        }

        if(isset($params['price_from'])){
          $sql .= 'AND price BETWEEN :price_from AND :price_to ';
          $placeholder_arr['price_from'] = $params['price_from'];
          $placeholder_arr['price_to'] = $params['price_to'];
        }


        if(isset($params['date_from']) && isset($params['date_to'])){
          $sql .= 'AND (events.event_start_time BETWEEN :date_from AND :date_to OR events.event_end_time BETWEEN :date_from AND :date_to) ';
          $date_from = date('Y-m-d', strtotime($params["date_from"]) - 86400);
          $date_from = $params["date_from"];
          $placeholder_arr['date_from'] = $date_from;
          $date_to = date('Y-m-d', strtotime($params["date_to"]) + 86400);
          $placeholder_arr['date_to'] = $date_to;
        }


        if(isset($params['type'])){
          $testInt = explode(',',$params['type'])[0];
          if(is_numeric($testInt)){
          $sql .= 'AND events.event_type IN ('.$params["type"].') ';
          }
        }


        if(isset($params['lectors'])){
          $testInt = explode(',',$params['lectors'])[0];
          if(is_numeric($testInt)){
          $sql .= 'AND events.lector_id LIKE "%'.$params["lectors"].'%" ';
          }
        }

        if(!isset($params['date_to']) && !isset($params['date_from'])){
          $sql .= 'AND event_end_time >= :nowDate ';
          $placeholder_arr['nowDate'] = $nowDate;
        }

        if(isset($params['is_free'])){
          $sql .= 'AND is_free = 0 ';
        }


        $sql .= 'ORDER BY events.id DESC';

        $stmt = $conn->prepare($sql);
        $stmt->execute($placeholder_arr);
        return $stmt->fetchAll();

      }


      //получение ВСЕХ мироприятий попавших под фильтрацию
      public function get_all_filtred_events($params){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE user_id IS NOT NULL
        ';

        $placeholder_arr = [];

        if(isset($params['event_ways'])){
          $testInt = explode(',',$params['event_ways'])[0];
          if(is_numeric($testInt)){
          $sql .= 'AND event_way.id IN ('.$params["event_ways"].') ';
          }
        }



        if(isset($params['price_from'])){
          $sql .= 'AND price BETWEEN :price_from AND :price_to ';
          $placeholder_arr['price_from'] = $params['price_from'];
          $placeholder_arr['price_to'] = $params['price_to'];
        }


        if(isset($params['date_from']) && isset($params['date_to'])){
          $sql .= 'AND (events.event_start_time BETWEEN :date_from AND :date_to OR events.event_end_time BETWEEN :date_from AND :date_to) ';
          $date_from = date('Y-m-d', strtotime($params["date_from"]) - 86400);
          $date_from = $params["date_from"];
          $placeholder_arr['date_from'] = $date_from;
          $date_to = date('Y-m-d', strtotime($params["date_to"]) + 86400);
          $placeholder_arr['date_to'] = $date_to;
        }


        if(isset($params['type'])){
          $testInt = explode(',',$params['type'])[0];
          if(is_numeric($testInt)){
          $sql .= 'AND events.event_type IN ('.$params["type"].') ';
          }
        }


        if(isset($params['lectors'])){
          $testInt = explode(',',$params['lectors'])[0];
          if(is_numeric($testInt)){
          $sql .= 'AND events.lector_id LIKE "%'.$params["lectors"].'%" ';
          }
        }


        if(isset($params['citys'])){
          $sql .= 'AND events.event_city IN ('.$params['citys'].') ';
        }


        if(!isset($params['date_to']) && !isset($params['date_from'])){
          $sql .= 'AND event_end_time >= :nowDate ';
          $placeholder_arr['nowDate'] = $nowDate;
        }

        if(isset($params['is_free'])){
          $sql .= 'AND is_free = 0 ';
        }



        $sql .= 'ORDER BY events.id DESC';

        $stmt = $conn->prepare($sql);
        $stmt->execute($placeholder_arr);
        return $stmt->fetchAll();

      }


      //получение одного последнего мироприятия пользователя
      public function get_my_events_solo($user_id){

        $conn = $this->getEntityManager()->getConnection();
        $nowDate = date('Y-m-d');

        $sql = '
        SELECT events.id, events.user_id, events.event_name, events.event_type,
        events.event_way, events.event_address, events.event_start_time, events.event_end_time,
        events.lector_id, events.event_photos, events.event_description, events.is_free,
        events.price , events.is_discount , events.rule_point, events.rule_sertificate,
        events.event_main_img, events.event_city, events.event_discount_percent,
        event_type.type_name, event_way.way_name, event_way.color, lectors.photo, lectors.full_name, lectors.worker_position
        FROM events
        JOIN event_type ON events.event_type = event_type.id
        JOIN event_way ON event_way.id = CAST(json_extract(events.event_way, "$[0]") AS UNSIGNED)
        JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
        WHERE user_id = :user_id AND event_end_time >= :nowDate
        ORDER BY events.id DESC
        LIMIT 1
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'nowDate' => $nowDate]);
        return $stmt->fetchAll();

      }

      //поиск по json_id
      public function json_search_id($table,$id){

            $conn = $this->getEntityManager()->getConnection();

            $dateNow = date('Y-m-d H:i:s');

            $sql = "
            SELECT *
            FROM `events`
            WHERE json_contains(".$table."->'$[*]',json_array('".$id."')) AND event_end_time >= :dateNow
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute(['dateNow'=>$dateNow]);
            return $stmt->fetchAll();
      }

}
