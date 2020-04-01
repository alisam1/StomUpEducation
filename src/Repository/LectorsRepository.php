<?php

namespace App\Repository;

use App\Entity\Lectors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Lectors|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lectors|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lectors[]    findAll()
 * @method Lectors[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LectorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lectors::class);
    }

    //Создаем нового лектора
    public function create_lector($full_name,$worker_position,$phone,$email,$photo,$in_center,$about){

      $em = $this->getEntityManager();

       $lector = new Lectors();
       $lector->setFullName($full_name);
       $lector->setWorkerPosition($worker_position);
       $lector->setPhone($phone);
       $lector->setEmail($email);
       $lector->setPhoto($photo);
       $lector->setInCenters($in_center);
       $lector->setAbout($about);

       $em->persist($lector);

       $em->flush();

       return $lector->getId();
    }

    //получить всех лекторов
    public function get_all_lectors(){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM lectors
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();

    }


    //получить совпадения лекторов по имени
    public function get_like_lector($like_name){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM lectors
      WHERE full_name LIKE :like_name
      ';

      $like_name = '%'.$like_name.'%';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['like_name'=>$like_name]);
      return $stmt->fetchAll();

    }


    //получить лекторов пользователя
    public function get_user_lectors($user_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT * FROM lectors WHERE in_centers LIKE :user_id
      ';

      $user_id = '%\"'.$user_id.'\"%';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user_id'=>$user_id]);
      return $stmt->fetchAll();

    }


    //получить 3 последних лектора у пользователя
    public function get_user_lectors_last_three($user_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT * FROM lectors WHERE in_centers LIKE :user_id
      ORDER BY lectors.id DESC
      LIMIT 3
      ';

      $user_id = '%\"'.$user_id.'\"%';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user_id'=>$user_id]);
      return $stmt->fetchAll();

    }


    //Найти лектора по его id
    public function get_lector_by_id($lector_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT * FROM lectors
      WHERE id = :lector_id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute([ 'lector_id'=>$lector_id ]);
      return $stmt->fetchAll();

    }


    //Найти все активные events в которых учавствует лектор
    public function get_active_events_by_lector($lector_id){

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
      WHERE lector_id LIKE :lector_id AND event_end_time >= :nowDate
      ORDER BY events.id DESC
      ';


      $lector_id = '%\"'.$lector_id.'\"%';

      $stmt = $conn->prepare($sql);
      $stmt->execute([ 'lector_id'=>$lector_id, 'nowDate'=>$nowDate ]);
      return $stmt->fetchAll();

    }


    //проверить лектора
    public function check_lector($full_name){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT id
      FROM lectors
      WHERE full_name = :full_name
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['full_name'=>$full_name]);
      return $stmt->fetchAll();

    }

    //ищем лектора по id
    public function find_lector_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM lectors
      WHERE id = :id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);
      return $stmt->fetchAll();
    }


    //ищем лектора частичному совпадению
    public function find_lector_like($user_id, $like){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM lectors
      WHERE in_centers LIKE :user_id AND full_name LIKE :like
      ';

      $user_id = '%\"'.(int)$user_id.'\"%';
      $like = '%'.$like.'%';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user_id'=>$user_id, 'like'=>$like]);
      return $stmt->fetchAll();
    }

    //Поиск по всем лекторам LIKE
    public function find_free_lector_like($like){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM lectors
      WHERE full_name LIKE :like
      ';

      $like = '%'.$like.'%';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['like'=>$like]);
      return $stmt->fetchAll();

    }

    //Обновляем лектора
    public function lector_update($lector_id, $full_name,$worker_position,$phone,$email,$photo,$in_center){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE lectors
      SET full_name = :full_name, worker_position = :worker_position, phone = :phone, email = :email, photo = :photo, in_centers = :in_center
      WHERE id = :id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'id'=>$lector_id,
        'full_name'=>$full_name,
        'worker_position'=>$worker_position,
        'phone'=>$phone,
        'email'=>$email,
        'photo'=>$photo,
        'in_center'=>json_encode($in_center)
      ]);

      return 'ok';

    }


}
