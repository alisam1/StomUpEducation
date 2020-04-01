<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    //получаем сообщения адресованные мне
    public function get_my_message_uniq($to_user_id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT from_user_id ,message, file_link, datetime , is_read, user_details.full_name
      FROM messages
      JOIN user_details ON user_details.user_id = messages.from_user_id
      WHERE to_user_id = :to_user_id
      OR from_user_id =:to_user_id
      GROUP BY messages.from_user_id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['to_user_id'=>$to_user_id]);
      return $stmt->fetchAll();

    }

    //открываем переписку
    public function get_our_message($from,$to){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT from_user_id ,message, file_link, datetime , is_read, user_details.full_name
      FROM messages
      JOIN user_details ON user_details.user_id = messages.from_user_id
      WHERE to_user_id = :to_user_id AND from_user_id = :from_user_id
      OR from_user_id = :to_user_id AND to_user_id = :from_user_id
      ORDER BY datetime
      LIMIT 25
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['to_user_id'=>$to,'from_user_id'=>$from]);
      return $stmt->fetchAll();

    }

    //делаем сообщения прочитанными
    public function read($id){

    }

    //Фиксируем новое сообщение
    public function new_msg($from_id,$to_id,$msg,$users_data,$my_data){

      $datetime = new \DateTime('@'.strtotime('now'));
      $time = date('Y-m-d H:i:s');
      // DEBUG: Доделать файллинки
      $filelink = NULL;

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      INSERT INTO messages
      VALUES(NULL,:from_user_id,:to_user_id,:message,:filelink,:datetime,0)
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(
        ['to_user_id'=>$to_id,
        'from_user_id'=>$from_id,
        'message'=>$msg,
        'filelink'=>$filelink,
        'datetime'=>$time
      ]);

      // -----Работа с сокетом-----
      $salt = $users_data[0]['id'];
      $name_sender = $my_data[0]['full_name'];


      $socket_data = [
        $name_sender,
        $time,
        $msg
      ];

      //Путь к сокетПрокси
      // $localsocket = 'tcp://192.168.1.67:6234';
      $localsocket = 'tcp://192.168.1.193:6234';
      //Идентификатор сокета
      $user = $salt;
      //Сообщение
      $message = json_encode($socket_data);

      // соединяемся с локальным tcp-сервером
      $instance = stream_socket_client($localsocket);
      // отправляем сообщение
      fwrite($instance, json_encode(['user' => $user, 'message' => $message])  . "\n");

      return $message;

    }



}
