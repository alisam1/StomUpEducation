<?php

namespace App\Services;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use App\Repository\UsersRepository;
use App\Repository\UserActionLogRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class UsersService
{

  public function __construct(UserActionLogRepository $userActionLogRepository)
  {
       $this->userActionLogRepository = $userActionLogRepository;
  }

  public function make_random_salt(){

    $length = 12;
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }

    return $string;

  }

  public function is_login(){
    $session = new Session;
    // $ul = new UsersRepository;

    if($session->has('f22')){
      $resp = $session->get('f22');
      $user_id = $resp->id;
      $dateTimeNow = date('Y-m-d H:i:s');
      $ip = $_SERVER['REMOTE_ADDR'];

      $this->userActionLogRepository->update_active($user_id,$dateTimeNow,$ip);


    } else {
      $resp = FALSE;
    }

    return $resp;
  }


}

 ?>
