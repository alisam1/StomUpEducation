<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use App\Repository\EventsRepository;
use App\Repository\EventTypeRepository;
use App\Repository\EventWayRepository;
use App\Repository\LectorsRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Detection\MobileDetect;
use App\Services\UsersService;
use Symfony\Component\HttpFoundation\Request;



class EventsController extends AbstractController
{


    /**
     * @Route("/cabinet/events", host="{domain}", defaults={"domain"="mededucation.pro"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function events_user_list(EventsRepository $eventsRepository, UsersService $userService, Request $request, LectorsRepository $lectorsRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, UsersRepository $userRepository){

      $mobileDetector = new MobileDetect;
      // проверка залогинен ли пользователь
      if( $userService->is_login() ){

        $my_id = $userService->is_login()->id;

        $user_type = $userService->is_login()->type;

        $userData = $userRepository->find_by_id($my_id);



        //Если это обучающий центр
        if($user_type == 1){

          if(isset($_GET['fill'])){

            $my_events = $eventsRepository->get_my_events_fill($my_id, $_GET);

          } else {
            $my_events = $eventsRepository->get_my_events($my_id);

          }

        $all_event_type = $eventTypeRepository->get_events_type();
        // $all_event_way = $eventWayRepository->get_events_way();
        $all_event_way = $eventWayRepository->get_user_active_events_way($my_id);

        $lectors_list = $lectorsRepository->get_user_lectors($my_id);


        return $this->render('center/events/events.twig', [
            'user_data' => $userData[0],
            'mobileDetect'=> $mobileDetector->isMobile(),
            'my_id'=>$my_id,
            'my_events' => $my_events,
            'all_event_type' => $all_event_type,
            'all_event_way' => $all_event_way,
            'lectors_list' => $lectors_list,
            'user_type' => $user_type
        ]);
        }
        // Если это слушатель
        elseif ( $user_type == 2 ) {

          $my_events = $eventsRepository->get_my_invited_events($my_id);
          $my_past_events = $eventsRepository->get_my_past_events($my_id);

          return $this->render('listener/events/events.twig', [
              'userData' => $userData[0],
              'mobileDetect'=> $mobileDetector->isMobile(),
              'my_id'=>$my_id,
              'my_events' => $my_events,
              'my_past_events' => $my_past_events
          ]);
        }

      } else {
        return $this->redirect('/');
      }

    }


    /**
     * @Route("/cabinet/events/{id}", name="events_view")
     */
    public function events_view($id = null, EventsRepository $eventsRepository, UsersRepository $userRepository, UsersService $userService, LectorsRepository $lectorsRepository)
    {

      $mobileDetector = new MobileDetect;

      if( $userService->is_login() ){

      $my_id = $userService->is_login()->id;
      $user_type = $userService->is_login()->type;
      $event_data = $eventsRepository->get_event_by_id($id)[0];
      $userData = $userRepository->find_by_id($my_id);
      $event_photos = json_decode($event_data['event_photos']);
      $lector_id = json_decode($event_data['lector_id'])[0];
      $lector_data = $lectorsRepository->find_lector_by_id($lector_id);
      $my_events = $eventsRepository->get_my_events_limit($my_id,10);
      $event_type = $eventsRepository->get_events_type();
      $event_way = $eventsRepository->get_events_way();
      $get_user_lectors = $lectorsRepository->get_user_lectors($my_id);

      // dd($event_data);

      //Если лекционный центр
      if($user_type == '1' && $event_data['user_id'] == $my_id ){
        return $this->render('center/events/events.view.twig', [
            'messanges' => 'test',
            'event' => $event_data,
            'user_data' => $userData[0],
            'event_photos' => $event_photos,
            'lector_data' => $lector_data[0],
            'my_events'=> $my_events,
            'event_type'=>$event_type,
            'event_way'=>$event_way,
            'mobileDetect' => $mobileDetector->isMobile(),
            'lector_id'=>$lector_id,
            'get_user_lectors'=>$get_user_lectors,
        ]);
      } else {
        return $this->redirect('/cabinet');
      }

      } else {
        return $this->redirect('/');
      }
    }



}
