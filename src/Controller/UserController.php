<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UsersService;
use App\Repository\UsersRepository;
use App\Repository\LectorsRepository;
use App\Repository\EventsRepository;
use App\Repository\EventRequestRepository;
use App\Repository\SitesRepository;
use App\Repository\SitesBannersRepository;
use App\Repository\EventWayRepository;
use App\Repository\EventTypeRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Detection\MobileDetect;


class UserController extends AbstractController
{


  /**
   * @Route("/logout", name="logout", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
   */
   public function logout(UsersService $userService){
     $session = new Session;
     if($userService->is_login()){
       $session->remove('f22');
       return $this->redirect('/');
     } else {
       return $this->redirect('/');
     }
   }

    /**
     * @Route("/cabinet", name="cabinet", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function index(UsersRepository $userRepository, EventsRepository $eventsRepository , UsersService $userService, LectorsRepository $lectorsRepository, SitesRepository $sitesRepository, SitesBannersRepository $siteBannersRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, EventRequestRepository $eventRequestRepository)
    {
      $session = new Session;
      $mobileDetector = new MobileDetect;

      if( $userService->is_login() ){

        $userData = $userRepository->find_by_id($userService->is_login()->id);

        $my_id = $userService->is_login()->id;


        if(count($userData) == 0){
          $session->remove('f22');
          return $this->redirect('/');
        } else {
          $userData = $userData[0];
        }




        //Если слушатель
        if($userData['type'] == '2'){
          $my_events = $eventsRepository->get_my_invited_events($my_id);
          $user_events = $eventRequestRepository->get_listener_events($my_id);

          return $this->render('listener/cabinet/cabinet.twig', [
              'login'=>$userData['login'],
              'email'=>$userData['email'],
              'phone'=>$userData['phone'],
              'photo'=>$userData['photo_link'],
              'full_name'=>$userData['full_name'],
              'worker_position'=>$userData['worker_position'],
              'worker_city'=>$userData['worker_city'],
              'userData'=>$userData,
              'mobileDetect'=>$mobileDetector->isMobile(),
              'my_id'=>$my_id,
              'my_events' => $my_events,
              'user_type' => $userData['type'],
              'user_events' => $user_events
          ]);

          //Если обучающий центр
        } elseif($userData['type'] == '1') {

        $my_events = $eventsRepository->get_my_events($my_id);

        //Ищем личный сайт
        $site_exist = $sitesRepository->is_site_exist($my_id);

        $lectors_list = $lectorsRepository->get_user_lectors($my_id);

        if($site_exist){
        $banners = $siteBannersRepository->get_banners_by_id($site_exist);
        } else {
          $banners = [];
        }

        $events_request = $eventRequestRepository->get_requests_center($my_id);

        $all_event_type = $eventTypeRepository->get_events_type();
        $all_event_way = $eventWayRepository->get_events_way();

        return $this->render('center/cabinet/cabinet.twig', [
            'login'=>$userData['login'],
            'email'=>$userData['email'],
            'phone'=>$userData['phone'],
            'full_name'=>$userData['full_name'],
            'inn'=>$userData['inn'],
            'kpp'=>$userData['kpp'],
            'ogrn'=>$userData['ogrn'],
            'jur_name'=>$userData['jur_name'],
            'jur_address'=>$userData['jur_address'],
            'fiz_address'=>$userData['fiz_address'],
            'user_data'=>$userData,
            'mobileDetect'=>$mobileDetector->isMobile(),
            'my_id'=>$my_id,
            'lectors_list'=>$lectors_list,
            'my_events' => $my_events,
            'site_exist'=> $site_exist,
            'banners' => $banners,
            'user_type' => $userData['type'],
            'events_request' => $events_request,
            'all_event_way' => $all_event_way,
            'all_event_type'=>$all_event_type
        ]);

      }
      //Если админ
      elseif($userData['type'] == '66'){
        return $this->render('admin/cabinet/cabinet.twig', [
            'mobileDetect'=>$mobileDetector->isMobile(),
        ]);
      }

      } else {
        return $this->redirect('/');

      }


    }


    /**
     * @Route("/cabinet/profile", name="profile", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function profile(UsersRepository $userRepository, UsersService $userService)
    {
            $session = new Session;
            $mobileDetector = new MobileDetect;

            if($userService->is_login()){
              $my_id = $userService->is_login()->id;
              $user_type = $userService->is_login()->type;

              $userData = $userRepository->find_by_id($my_id);


              //Мы видим сессию -  по этому отрисовываем шаблон
              //Если это обучающий центр
              if($user_type == 1){

              return $this->render('center/profile/profile.twig', [
                  'user_data' => $userData[0],
                  'userFizAddr' => json_decode($userData[0]['fiz_address']),
                  'userJurAddr' => json_decode($userData[0]['jur_address']),
                  'mobileDetect' => $mobileDetector->isMobile(),
                  'my_id' => $my_id,
              ]);

              }
              //Если это слушатель
              elseif ($user_type == 2) {
                return $this->render('listener/profile/profile.twig', [
                    'userData' => $userData[0],
                    'mobileDetect' => $mobileDetector->isMobile(),
                    'my_id' => $my_id,
                ]);
              }

            } else {
              //Если не видим сессии - редирект на главную
              return $this->redirect('/');
            }


    }


    /**
     * @Route("/cabinet/api", name="api", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function api(UsersRepository $userRepository, UsersService $userService)
    {
            $session = new Session;
            $mobileDetector = new MobileDetect;

            if($userService->is_login()){
              $my_id = $userService->is_login()->id;
              $user_type = $userService->is_login()->type;

              $userData = $userRepository->find_by_id($my_id);


              //Мы видим сессию -  по этому отрисовываем шаблон
              //Если это обучающий центр
              if($user_type == 1){

              return $this->render('center/api/api.twig', [
                  'userData' => $userData[0],
                  'userFizAddr' => json_decode($userData[0]['fiz_address']),
                  'userJurAddr' => json_decode($userData[0]['jur_address']),
                  'mobileDetect' => $mobileDetector->isMobile(),
                  'my_id' => $my_id,
              ]);

              }
              //Если это слушатель
              elseif ($user_type == 2) {
                // dd($userData);
                return $this->render('listener/profile/profile.twig', [
                    'userData' => $userData[0],
                    'mobileDetect' => $mobileDetector->isMobile(),
                    'my_id' => $my_id,
                ]);
              }

            } else {
              //Если не видим сессии - редирект на главную
              return $this->redirect('/');
            }


    }


    /**
     * @Route("/registration", name="registration", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function registration(UsersService $userService)
    {
        $mobileDetector = new MobileDetect;

        if( $userService->is_login() ){

          return $this->redirectToRoute('cabinet');

        } else {

          return $this->render('user/registration.html.twig', [
              'controller_name' => 'registration',
              'mobileDetect' => $mobileDetector->isMobile(),
          ]);

        }


    }

    /**
     * @Route("/login", name="login", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function login(UsersService $userService)
    {
      $session = new Session;
      $mobileDetector = new MobileDetect;
      // dd($userService->is_login());
      if( $userService->is_login() ){


        return $this->redirectToRoute('cabinet');

      } else {

        return $this->render('user/login.html.twig', [
            'controller_name' => 'login',
            'mobileDetect' => $mobileDetector->isMobile()
        ]);

      }

    }


}
