<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\UserDetails;
use App\Entity\UserActionLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    //Создаем пользователя
    public function create_user($login,$pass,$email,$phone,$type,$salt,
    $full_name,$worker_position, $worker_city, $inn,
    $kpp, $ogrn, $jur_name, $jur_address, $fiz_address,$photo)
    {

      $em = $this->getEntityManager();


       $user = new Users();
       $user->setLogin($login);
       $user->setPassword($pass);
       $user->setEmail($email);
       $user->setPhone($phone);
       $user->setActive(1);
       $user->setType($type);
       $user->setSalt($salt);

       // скажите Doctrine, что вы (в итоге) хотите сохранить (пока без запросов)
       $em->persist($user);

       // на самом деле выполнить запросы (т.е. запрос INSERT)
       $em->flush();

       //фиксируем user_id
       $user_id = $user->getId();

       $userDetails = new UserDetails();
       $userDetails->setUserId($user_id);
       $userDetails->setFullName($full_name);
       $userDetails->setInn($inn);
       $userDetails->setKpp($kpp);
       $userDetails->setOgrn($ogrn);
       $userDetails->setJurName($jur_name);
       $userDetails->setJurAddress($jur_address);
       $userDetails->setFizAddress($fiz_address);
       $userDetails->setWorkerPosition($worker_position);
       $userDetails->setWorkerCity($worker_city);
       $userDetails->setPhotoLink($photo);

       $em->persist($userDetails);
       $em->flush();

       //Создаем первую запись о активности пользователя в таблицу ActiveLog

       $dateTimeNow = date('Y-m-d H:i:s');
       $ip = $_SERVER['REMOTE_ADDR'];


       $userActionLog = new UserActionLog();
       $userActionLog->setUserId($user_id);
       $userActionLog->setTime($dateTimeNow);
       $userActionLog->setIp($ip);

       $em->persist($userActionLog);
       $em->flush();


    }

    //меняем пароль пользователю
    public function change_password($user_id, $new_pass){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE users
      SET password = :new_pass
      WHERE id = :user_id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['new_pass'=>$new_pass, 'user_id'=>$user_id]);
      return 'ok';

    }

    //Проверяем пользователя
    public function check_user($phone){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT phone
      FROM users
      WHERE phone = :phone
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['phone'=>$phone]);
      return $stmt->fetchAll();

    }

    //Проверка входа в систему
    public function login_check($phone,$password){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT id, type
      FROM users
      WHERE password =:password AND phone = :phone
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['phone'=>$phone,
                      'password'=>$password]);
      $arrSt = $stmt->fetchAll();

      if(count($arrSt) != 0){
        return json_encode($arrSt);
      } else {
        return 'Fail';
      }

    }

    //найти пользователя по ID
    public function find_by_id($id){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT users.id, users.type , users.login, users.email, users.phone, users.salt , user_details.full_name,user_details.inn,user_details.kpp,user_details.ogrn, user_details.jur_name,
      user_details.jur_address,user_details.fiz_address,user_details.worker_position,user_details.worker_city , user_details.photo_link
      FROM users JOIN user_details
      ON users.id=user_details.user_id
      WHERE users.id = :id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id]);
      $arrSt = $stmt->fetchAll();

        return $arrSt;
    }

    //найти пользователя по соли
    public function find_user_by_salt($salt){
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM users
      WHERE salt = :salt
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['salt'=>$salt]);
      $answr = $stmt->fetchAll();

      return $answr;

    }


    //ищем пользователя по номеру телефона
    public function find_user_by_phone($phone){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      SELECT *
      FROM users
      WHERE phone = :phone
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute(['phone'=>$phone]);
      return $stmt->fetchAll();

    }


    //Обновить солевую запись
    public function update_slt($id){
      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE users
      SET salt = :salt
      WHERE id = :id
      ';

      $stmt = $conn->prepare($sql);
      $stmt->execute(['id'=>$id, 'salt'=>$_COOKIE['PHPSESSID']]);
      // $arrSt = $stmt->fetchAll();
      return 'ok';
    }

    //Обновляем данные центра
    public function update_user_center(
      $user_id,$full_name,$photo,
      $phone,$email,$inn,
      $kpp,$jur_name,$jur_address,$fiz_address){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE users u, user_details ud
        SET
        u.login = :login,
        u.email = :email,
        u.phone = :phone,
        ud.full_name = :full_name,
        ud.inn = :inn,
        ud.kpp = :kpp,
        ud.jur_name = :jur_name,
        ud.jur_address = :jur_address,
        ud.fiz_address = :fiz_address,
        ud.photo_link = :photo
        WHERE u.id=ud.user_id AND u.id = :user_id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(
          [
          'login'=>$phone,
          'phone'=>$phone,
          'email'=>$email,
          'full_name'=>$full_name,
          'inn'=>$inn,
          'kpp'=>$kpp,
          'jur_name'=>$jur_name,
          'jur_address'=>json_encode($jur_address),
          'fiz_address'=>json_encode($fiz_address),
          'photo'=>$photo,
          'user_id'=>$user_id
        ]);

        return 'ok';

    }


    //Обновляем данные слушателя
    public function update_user_listener(
      $user_id,$full_name,$photo,
      $phone,$email,$worker_position,$worker_city){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE users u, user_details ud
        SET
        u.login = :login,
        u.email = :email,
        u.phone = :phone,
        ud.full_name = :full_name,
        ud.worker_position = :worker_position,
        ud.worker_city = :worker_city,
        ud.photo_link = :photo
        WHERE u.id=ud.user_id AND u.id = :user_id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(
          [
          'login'=>$phone,
          'phone'=>$phone,
          'email'=>$email,
          'full_name'=>$full_name,
          'worker_position'=>$worker_position,
          'worker_city'=>$worker_city,
          'photo'=>$photo,
          'user_id'=>$user_id
        ]);

        return 'ok';

    }


}
