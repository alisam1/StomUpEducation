<?php

namespace App\Repository;

use App\Entity\EventRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRequest[]    findAll()
 * @method EventRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRequest::class);
    }


    //создание заявки на мероприятие для пользователя
    public function create_event_request_by_user($event_id, $user_id, $center_id, $full_name, $phone, $email)
      {

        $em = $this->getEntityManager();

        //Получаем текущую дату:
        $dateNow = date('Y-m-d H:i:s');


        $eventRequest = new EventRequest();
        $eventRequest->setUserId($user_id);
        $eventRequest->setEventId($event_id);
        $eventRequest->setCenterId($center_id);
        $eventRequest->setReqFullName($full_name);
        $eventRequest->setReqPhone($phone);
        $eventRequest->setReqEmail($email);
        $eventRequest->setDateCreated($dateNow);

        $em->persist($eventRequest);

        $em->flush();

      }



          //создание заявки на мероприятие для пользователя
          public function create_event_request_by_noname($event_id, $center_id, $full_name, $city, $phone, $comment, $email)
            {

              $em = $this->getEntityManager();

              //Получаем текущую дату:
              $dateNow = date('Y-m-d H:i:s');


              $eventRequest = new EventRequest();
              $eventRequest->setEventId($event_id);
              $eventRequest->setCenterId($center_id);
              $eventRequest->setDateCreated($dateNow);
              $eventRequest->setReqFullName($full_name);
              $eventRequest->setReqCity($city);
              $eventRequest->setReqPhone($phone);
              $eventRequest->setReqComment($comment);
              $eventRequest->setReqEmail($email);

              $em->persist($eventRequest);

              $em->flush();

            }


    //Получаем весь список заявок по id центра
    public function get_requests_center($center_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT event_request.user_id, event_request.event_id, event_request.pay_status, event_request.center_id,
      event_request.req_city, event_request.req_phone, event_request.req_comment, event_request.req_email, event_request.req_full_name,
      events.event_name, events.event_start_time, lectors.full_name, lectors.worker_position, lectors.photo 
      FROM event_request
      JOIN events ON event_request.event_id = events.id
      JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
      WHERE event_request.center_id = :center_id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['center_id'=>$center_id]);
      return $stmt->fetchAll();

    }


    //Проверяем записан ли пользователь на данное мероприятие
    public function check_user_on_event($user_id, $event_id){
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM event_request
      WHERE user_id = :user_id AND event_id = :event_id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
      return $stmt->fetchAll();
    }



    //Получаем мероприятия на которые записан пользователь
    public function get_listener_events($user_id){

      $dateNow = date('Y-m-d H:i:s');

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM event_request
      JOIN events ON event_request.event_id = events.id
      JOIN lectors ON lectors.id = CAST(json_extract(events.lector_id, "$[0]") AS UNSIGNED)
      WHERE event_request.user_id = :user_id AND events.event_start_time > :dateNow
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user_id' => $user_id, 'dateNow' => $dateNow]);
      return $stmt->fetchAll();
    }


}
