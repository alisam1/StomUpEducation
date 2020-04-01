<?php

namespace App\Services;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use App\Repository\UsersRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;


class SmsService
{


  public function __construct()
  {
      $this->sms = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth('5DBD63DB-6E3E-B1E7-D550-49A87BEC9291'));
  }


//Отправка sms, базовая
public function send($phone,$text){

  $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $text);
  $this->sms->smsSend($sms);

  return 'ok';

}


//Узнать стоимость отправки
public function cost($phone,$text){

return $this->sms->smsCost(new \Zelenin\SmsRu\Entity\Sms($phone, $text));

}


//Баланс
public function balance(){

return $this->sms->myBalance();
}

}

 ?>
