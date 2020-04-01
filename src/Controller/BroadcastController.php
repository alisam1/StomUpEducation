<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\SmsService;
use App\Services\UsersService;
use App\Repository\UsersRepository;

class BroadcastController extends AbstractController
{


    /**
     * @Route("/broadcast", name="broadcast")
     */
    public function index()
    {

      // dd($sms->send('79219927367','Антон приглашаем вас на портал https://stomup.ru !'));

      // dd( $mailService->send_email("loisoj@gmail.com", "Подтверждение регистрации на StomUp", "<img src='https://laks-spb.stomup.ru/uploads/sites/logo/63706938.png'/><h1>Подтвердите регистрацию</h1>") );

        return $this->render('broadcast/index.html.twig', [
            'controller_name' => 'BroadcastController',
        ]);
    }

    /**
     * @Route("/broadcast/{id}", name="broadcast_view")
     */
    public function broadcast_view(){
      return $this->render('broadcast/view.broadcast.twig', [
          'controller_name' => 'BroadcastViewController',
      ]);
    }


    /**
     * @Route("/cabinet/mybroadcasts", name="mybroadcasts")
     */
    public function my_broadcasts(UsersService $userService, UsersRepository $userRepository){

      if( $userService->is_login() ){

        $userData = $userRepository->find_by_id($userService->is_login()->id);

        if(count($userData) == 0){
          $session->remove('f22');
          return $this->redirect('/');
        } else {
          $userData = $userData[0];
        }

        //Если это лекционный центр
        if($userData['type'] == '1'){

        return $this->render('broadcast/my.cabinet.twig', [
            'userData' => $userData,
        ]);

      } else {
        return $this->redirect('/cabinet');
      }

      } else {

          return $this->redirect('/');

      }

    }
}
