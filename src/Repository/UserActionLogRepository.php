<?php

namespace App\Repository;

use App\Entity\UserActionLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserActionLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserActionLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserActionLog[]    findAll()
 * @method UserActionLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserActionLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserActionLog::class);
    }

    //Функция которая обновляет лог пользователя
    public function update_active($user_id, $time, $ip){

      $conn = $this->getEntityManager()->getConnection();

      $sql = '
      UPDATE user_action_log
      SET time = :time, ip = :ip 
      WHERE user_id = :user_id
      ';
      //
      $stmt = $conn->prepare($sql);
      $stmt->execute([
        'time'=>$time,
        'user_id'=>$user_id,
        'ip'=>$ip
      ]);

      // return $stmt->fetchAll();

    }

}
