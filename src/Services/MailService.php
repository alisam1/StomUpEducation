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


class MailService
{


  public function __construct(\Swift_Mailer $mailer)
  {
      $this->mailer = $mailer;
  }


//Отправка почты, базовая
public function send_email($to,$theme,$body){

  $message = $this->mailer->createMessage()
      ->setSubject($theme)
      ->setFrom('noreply@stomup.ru')
      ->setTo($to)
      ->setBody($body, 'text/html')
              ;

   $this->mailer->send($message);

}

//Отправка письма с кодом востановления пароля
public function recoverby_email($user_email, $recover_key){


  $message = $this->mailer->createMessage()
      ->setSubject('StomUp')
      ->setFrom('noreply@stomup.ru')
      ->setTo($user_email)
      ->setBody('<h1>Для востановления пароля, перейдите по <a href="https://stomup.ru/recoverme/'.$recover_key.'">ссылке</a> </h1>', 'text/html')
              ;

   $this->mailer->send($message);

}



}

 ?>
