<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UsersService;
use App\Repository\SitesRepository;
use App\Repository\UsersRepository;
use App\Repository\EventsRepository;
use App\Repository\LectorsRepository;
use App\Repository\SitesBannersRepository;
use App\Repository\SitesReviewRepository;
use App\Repository\EventWayRepository;
use App\Repository\EventTypeRepository;
use Detection\MobileDetect;

class PersonalSiteController extends AbstractController
{
    /**
     * @Route("/cabinet/site", name="personal_site")
     */
    public function index(UsersService $userService, SitesRepository $sitesRepository, LectorsRepository $lectorsRepository , SitesReviewRepository $sitesReviewRepository, EventsRepository $eventsRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, UsersRepository $userRepository)
    {

      $mobileDetector = new MobileDetect;



      if( $userService->is_login() ){
        $user_id = $userService->is_login()->id;
        $userData = $userRepository->find_by_id($user_id);

        //Если это центр
        if($userData[0]['type'] == '1'){

          $all_event_type = $eventTypeRepository->get_events_type();
          $all_event_way = $eventWayRepository->get_events_way();


        $lectors_list = $lectorsRepository->get_user_lectors_last_three($user_id);

        for ($i=0; $i < count($lectors_list); $i++) {
          $lector_id = $lectors_list[$i]['id'];
          $my_events_list = $eventsRepository->json_search_id('lector_id',$lector_id);

          $lectors_list[$i]['events'] = $my_events_list;
        }

        //Чекаем эвенты
        $my_events = $eventsRepository->get_my_events($user_id);



        if($mobileDetector->isMobile()){
          return $this->render('center/personal_site/mobile.twig', [
            'my_events'=>$my_events,
            'lectors_list'=>$lectors_list,
            'my_id' => $user_id,
            'user_type'=> $userData[0]['type'],
            'user_data'=>$userData[0],
            'all_event_way' => $all_event_way,
            'all_event_type'=>$all_event_type
           ]);
        }

        //Проверяем существет ли пользователь
        //Если существует
        if($sitesRepository->is_site_exist($user_id)){

          //Подгружаем данные сайта
          $site_data = $sitesRepository->get_site_data($user_id)[0];
          $work_time = explode(' - ',$site_data['site_info_worktime']);


          $site_id = $site_data['id'];

          $site_last_review = $sitesReviewRepository->get_one_data_by_site($site_id);



          return $this->render('center/personal_site/my.site.twig', [
              'lectors_list' => $lectors_list,
              'my_id'=>$user_id,
              'site_data' => $site_data,
              'work_time' => $work_time,
              'my_events' => $my_events,
              'site_last_review'=>$site_last_review,
              'user_type' => $userData[0]['type'],
              'user_data'=>$userData[0],
              'all_event_way' => $all_event_way,
              'all_event_type'=>$all_event_type
          ]);

        }
        //Если не существует
        else {



          return $this->render('center/personal_site/new.site.twig', [
              'lectors_list' => $lectors_list,
              'my_id'=>$user_id,
              'my_events' => $my_events,
              'user_type' => $userData[0]['type'],
              'user_data'=>$userData[0],
              'all_event_way' => $all_event_way,
              'all_event_type'=>$all_event_type
          ]);
        }

        //Если это не лекционный центр
      }
      else {
        return $this->redirect('/cabinet');
      }



      }
      else {
        return $this->redirect('/');
      }

    }



    /**
     * @Route("/cabinet/site/banners", name="banners")
     */
    public function banners(UsersService $userService, SitesRepository $sitesRepository, LectorsRepository $lectorsRepository, EventsRepository $eventsRepository, SitesBannersRepository $siteBannersRepository, UsersRepository $userRepository)
    {

      $mobileDetector = new MobileDetect;


      if( $userService->is_login() ){

        $user_id = $userService->is_login()->id;
        $userData = $userRepository->find_by_id($user_id);
        //Получаем id сайта с которым работаем
        $get_site_id = $sitesRepository->is_site_exist($user_id);

        //Если вернули не FALSE - получаем данные по баннерам
        if($get_site_id){
          $banners_data = $siteBannersRepository->get_banners_by_id($get_site_id);
        } else {
          $banners_data = [];
        }

          return $this->render('center/personal_site/banners.twig', [
            'my_id' => $user_id,
            'banners_data' => $banners_data,
            'user_data'=>$userData[0],
           ]);



      }
      else {
        return $this->redirect('/');
      }

    }


    /**
     * @Route("/cabinet/site/comment", name="comment")
     */
    public function comment(UsersService $userService, SitesRepository $sitesRepository, LectorsRepository $lectorsRepository, EventsRepository $eventsRepository, SitesReviewRepository $sitesReviewRepository, UsersRepository $userRepository)
    {

      $mobileDetector = new MobileDetect;


      if( $userService->is_login() ){

        $user_id = $userService->is_login()->id;
        $userData = $userRepository->find_by_id($user_id);
        //Получаем id сайта с которым работаем
        $get_site_id = $sitesRepository->is_site_exist($user_id);
        $get_review_data = $sitesReviewRepository->get_data_by_site($get_site_id);

        if($mobileDetector->isMobile()){
          return $this->render('center/personal_site/comment.mobile.twig', [
            'my_id' => $user_id,
            'review_data'=>$get_review_data,
            'userData'=>$userData[0],
           ]);
         }  else {
           return $this->render('center/personal_site/comment.desktop.twig', [
             'my_id' => $user_id,
             'review_data'=>$get_review_data,
             'user_data'=>$userData[0],
            ]);
         }


      }
      else {
        return $this->redirect('/');
      }

    }

}
