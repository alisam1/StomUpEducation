<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use App\Repository\RecoverPassRepository;
use App\Services\PhoneService;
use App\Services\MailService;
use App\Services\CryptoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecoverController extends AbstractController
{
    /**
     * @Route("/forget", name="forget")
     */
    public function forgot(UsersRepository $userRepository, PhoneService $phoneService, CryptoService $crypto)
    {
      // Проверяем, есть ли такой номер телефона
      if(isset($_GET['phoner']) && $_GET['phoner'] != ''){

        // чистим номер телефона
        $phone = $phoneService->clear_phone($_GET['phoner']);
        //Ищщем данные о пользователе
        $try_to_find_user = $userRepository->find_user_by_phone($phone);

        //Если нашли
        if(count($try_to_find_user) == 1){
          // dd(strpos($try_to_find_user[0]['email'],'111111'));
          $user_data = $try_to_find_user[0];

          //Если есть email - отправляем на email
          if( !is_null($user_data['email']) && $user_data['email'] != '' && strpos($user_data['email'],'@') !== false ){
            // dd($user_data['email']);
            return $this->redirect('/recoverby/email?msg='.$user_data['id'].'');
          }
          // Иначе, отправляем SMS
          else{
            return $this->redirect('/recoverby/sms');

          }

        }
        //Если не нашли
        else {

          dd('Такого пользователя не существует');

          return $this->render('recover/index.html.twig', [
              'controller_name' => 'RecoverController',
          ]);
        }



      }

      dd('Не указан номер телефона');


    }


    /**
     * @Route("/recoverby/email", name="email")
     */
    public function recoverby_email(MailService $mailService, Request $request, UsersRepository $userRepository, RecoverPassRepository $recoverPassRepository)
    {

      $tryer = substr( $request->server->get('HTTP_REFERER'), -5 );


      if($tryer == 'login'){
        //Ловим id пользователя и находим все данные о нем по id
        $user_id = $_GET['msg'];
        $user_data = $userRepository->find_by_id($user_id)[0];

        $recover_string = $recoverPassRepository->add_recovery($user_id);


      //Отправляем сообщение
      $mailService->recoverby_email($user_data['email'], $recover_string);

      //Уведомляем об успешной отправке сообщения

        return $this->render('recover/by.email.twig', [
            'controller_name' => 'RecoverController',
        ]);

        }

        return $this->redirect('/login');
    }


    /**
     * @Route("/recoverby/sms", name="sms")
     */
    public function recoverby_sms()
    {

      //Уведомляем об успешной отправке сообщения


        return $this->render('recover/index.html.twig', [
            'controller_name' => 'RecoverController',
        ]);
    }


    /**
     * @Route("/recoverme/{key}", name="recoverme")
     */
    public function recoverme($key = null, RecoverPassRepository $recoverPassRepository)
    {
      // dd('test');
      //Если указан ключ
      if($key != null){

        //Ищем этот ключ в списке запросов на востановление
        //Если находим - позволяем пользователю сменить пароль
        $answer = $recoverPassRepository->use_recovery($key);

        if($answer != FALSE){

          return $this->render('recover/recover.page.twig', [
              'key' => $key,
          ]);

        } else {
          return $this->redirect('/login');
        }

      }

      return $this->redirect('/login');


    }


    /**
     * @Route("/catch_recovere", name="catch_recovere")
     */
    public function catch_recovere($key = null, RecoverPassRepository $recoverPassRepository, Request $request, UsersRepository $userRepository)
    {

        //Ловим ключ по POST и новый пароль пользователя
        $new_pass = md5(md5($request->request->get('pass_first')));
        $key = $request->request->get('key');

        //Выясняем по ключу id пользователя
        $user_id = $recoverPassRepository->use_recovery($key);

        //Меняем пароль пользователю
        $userRepository->change_password($user_id,$new_pass);

        //Деактивируем ключ
        $recoverPassRepository->key_deactivate($key);

        //Отвечаем что все ок
        return new Response('ok');


    }



}
