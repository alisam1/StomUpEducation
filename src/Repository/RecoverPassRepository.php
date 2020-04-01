<?php

namespace App\Repository;

use App\Entity\RecoverPass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RecoverPass|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecoverPass|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecoverPass[]    findAll()
 * @method RecoverPass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecoverPassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecoverPass::class);
    }

    //Метод для создания записи о изменении пароля и генерации ссылки
    public function add_recovery($user_id){

      // генерируем рандомную строку
      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%-!';
      $random_string = substr(str_shuffle($permitted_chars), 0, 32);
      $date_now = date('Y-m-d H:i:s');

      $em = $this->getEntityManager();

       $recoverSystem = new RecoverPass();
       $recoverSystem->setUserId($user_id);
       $recoverSystem->setRecoverKey($random_string);
       $recoverSystem->setActive(1);
       $recoverSystem->setTimeCreated($date_now);


       // скажите Doctrine, что вы (в итоге) хотите сохранить (пока без запросов)
       $em->persist($recoverSystem);

       // на самом деле выполнить запросы (т.е. запрос INSERT)
       $em->flush();

       return $random_string;

    }


    //Поиск разрешения на востановление по паролю
    public function use_recovery($recover_key){

        $conn = $this->getEntityManager()->getConnection();
        $date_to = date('Y-m-d H:i:s', strtotime("-1 day"));

        $sql = '
        SELECT *
        FROM recover_pass
        WHERE recover_key = :recover_key AND active = 1 AND time_created > :date_to
        ';
        //
        $stmt = $conn->prepare($sql);
        $stmt->execute(['recover_key'=>$recover_key, 'date_to'=>$date_to]);
        $find_some_one = $stmt->fetchAll();
        // dd($find_some_one);

        if(count($find_some_one) > 0){
         return $find_some_one[0]['user_id'];
       } else {
         return FALSE;
       }

    }

    //Деактивируем ключ
    public function key_deactivate($key){

            $conn = $this->getEntityManager()->getConnection();

            $sql = '
            UPDATE recover_pass
            SET active = 0
            WHERE recover_key = :key
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute(['key'=>$key]);
            return 'ok';
    }

}
