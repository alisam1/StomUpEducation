<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use App\Repository\EventsRepository;
use App\Repository\EventWayRepository;
use App\Repository\EventTypeRepository;
use App\Repository\LectorsRepository;
use App\Repository\SitesRepository;
use App\Repository\EventRequestRepository;
use Detection\MobileDetect;
use App\Services\UsersService;

use App\Services\PhoneService;
use App\Services\MapService;

class MainController extends AbstractController
{

  public function __construct(UsersService $userService){
    $this->user_id = $userService->is_login();
  }


    /**
     * @Route("/", name="main", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function index(EventsRepository $eventsRepository, SitesRepository $sitesRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, LectorsRepository $lectorsRepository)
    {

      $mobileDetector = new MobileDetect;

      //Реализовать фильтровую проверку
      if(isset($_GET['fill'])){
      //Если фильтр есть
      $my_events = $eventsRepository->get_all_filtred_events($_GET);
      } else {
      //Если фильтра нету:
      //Получить все события и отсортировать их по дате проведения
      $my_events = $eventsRepository->get_last_limit_events(5);
      }

      $centers_data = $sitesRepository->get_all_sites();

      //Подсчитываем количество events у центра и складываем их в массив данных центра
      for ($i=0; $i < count($centers_data); $i++) {
        $user_id = $centers_data[$i]['user_id'];

        $select_events = $eventsRepository->get_user_events($user_id);
        $count_select_events = count($select_events);
        $centers_data[$i]['actual_events'] = $count_select_events;
      }

        //Применяем функцию умной фильтрации
        uasort($centers_data, 'cmp_function');
        $centers_data = array_values($centers_data);

        //Получаем полезные данные для рендеринга
        $all_event_type = $eventTypeRepository->get_events_type();
        // $all_event_way = $eventWayRepository->get_events_way();
        $all_event_way = $eventWayRepository->get_active_events_way();

        $all_lectors = $lectorsRepository->get_all_lectors();
        $city_data = $eventsRepository->get_events_city();


        return $this->render('main/index.twig', [
            'controller_name' => 'MainController',
            'mobileDetect'=>$mobileDetector->isMobile(),
            'my_events' => $my_events,
            'centers_data' => $centers_data,
            'all_event_way' => $all_event_way,
            'all_event_type' => $all_event_type,
            'all_lectors' => $all_lectors,
            'city_data' =>$city_data,
            'is_user' => $this->user_id
        ]);
    }


    /**
     * @Route("/lectors", name="lectors", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function lectors( LectorsRepository $lectorsRepository)
    {

      $mobileDetector = new MobileDetect;

      $lectors_list = $lectorsRepository->get_all_lectors();

      for ($i=0; $i < count($lectors_list); $i++) {

        $find_events = count( $lectorsRepository->get_active_events_by_lector($lectors_list[$i]['id']) );
        $lectors_list[$i]['events_count'] = $find_events;

      }

      $legal_lectors = [
        'А'=>[],
        'Б'=>[],
        'В'=>[],
        'Г'=>[],
        'Д'=>[],
        'Е'=>[],
        'Ж'=>[],
        'З'=>[],
        'И'=>[],
        'К'=>[],
        'Л'=>[],
        'М'=>[],
        'Н'=>[],
        'О'=>[],
        'П'=>[],
        'Р'=>[],
        'С'=>[],
        'Т'=>[],
        'У'=>[],
        'Ф'=>[],
        'Х'=>[],
        'Ч'=>[],
        'Ш'=>[],
        'Э'=>[],
        'Ю'=>[],
        'Я'=>[],
        'A'=>[],
        'B'=>[],
        'C'=>[],
        'D'=>[],
        'E'=>[],
        'F'=>[],
        'G'=>[],
        'H'=>[],
        'I'=>[],
        'J'=>[],
        'K'=>[],
        'L'=>[],
        'M'=>[],
        'N'=>[],
        'O'=>[],
        'P'=>[],
        'Q'=>[],
        'R'=>[],
        'S'=>[],
        'T'=>[],
        'U'=>[],
        'V'=>[],
        'W'=>[],
        'X'=>[],
        'Y'=>[],
        'Z'=>[]
      ];


      for ($i=0; $i < count($lectors_list); $i++) {

        $tested_name = strtoupper($lectors_list[$i]['full_name']);

        $litteral = mb_substr($tested_name, 0, 1);

        $legal_lectors[$litteral][] = $lectors_list[$i];

      }



        return $this->render('main/lectors.twig', [
            'lectors_list' => $lectors_list,
            'mobileDetect'=>$mobileDetector->isMobile(),
            'legal_lectors' => $legal_lectors,
            'is_user' => $this->user_id
        ]);
    }


    /**
     * @Route("/events", name="events", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function events(EventWayRepository $eventWayRepository, EventTypeRepository $eventTypeRepository, EventsRepository $eventsRepository, LectorsRepository $lectorsRepository)
    {

      $mobileDetector = new MobileDetect;

      $all_event_type = $eventTypeRepository->get_events_type();
      $all_event_way = $eventWayRepository->get_events_way();

      if(isset($_GET['fill'])){

        $my_events = $eventsRepository->get_all_filtred_events($_GET);

      } else {
        $my_events = $eventsRepository->get_all_events();

      }

      $all_lectors = $lectorsRepository->get_all_lectors();

        return $this->render('main/events.twig', [
            'mobileDetect'=>$mobileDetector->isMobile(),
            'all_event_type' => $all_event_type,
            'all_event_way' => $all_event_way,
            'my_events' => $my_events,
            'all_lectors' => $all_lectors,
            'is_user' => $this->user_id
        ]);
    }


    /**
     * @Route("/events/{event_id}", name="event_id", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function event_id($event_id = null, EventsRepository $eventsRepository, UsersRepository $userRepository, LectorsRepository $lectorsRepository, UsersService $userService, EventRequestRepository $eventRequestRepository, SitesRepository $sitesRepository)
    {

      $mobileDetector = new MobileDetect;

      $event_data = $eventsRepository->get_event_by_id($event_id)[0];
      $owner_id = $event_data['user_id'];
      $user_data = $userRepository->find_by_id($owner_id);
      $site_data = $sitesRepository->get_site_data($owner_id);
      $event_photos = json_decode($event_data['event_photos']);
      $lector_id = json_decode($event_data['lector_id'])[0];
      $lector_data = $lectorsRepository->find_lector_by_id($lector_id);
      $my_events = $eventsRepository->get_all_events();

      if( $this->user_id ){
        $loginIn = $this->user_id->id;
        $onEvent = $eventRequestRepository->check_user_on_event($loginIn,$event_id);

            if(count($onEvent) == 0){
              $onEvent == FALSE;
            } else {
              $onEvent == TRUE;
            }

      } else {
        $loginIn = FALSE;
        $onEvent = FALSE;
      }

        return $this->render('main/view/event.view.twig', [
            'mobileDetect'=>$mobileDetector->isMobile(),
            'event' => $event_data,
            'user_data' => $user_data[0],
            'event_photos' => $event_photos,
            'lector_data' => $lector_data[0],
            'my_events' => $my_events,
            'is_login' => $loginIn,
            'on_event' => $onEvent,
            'is_user' => $this->user_id,
            'site_data' => $site_data,
        ]);
    }




    /**
     * @Route("/centers", name="centers", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function centers(SitesRepository $sitesRepository, EventsRepository $eventsRepository)
    {

      $mobileDetector = new MobileDetect;

      $centers_data = $sitesRepository->get_all_sites();

      //Подсчитываем количество events у центра и складываем их в массив данных центра
      for ($i=0; $i < count($centers_data); $i++) {
        $user_id = $centers_data[$i]['user_id'];

        $select_events = $eventsRepository->get_user_events($user_id);
        $count_select_events = count($select_events);
        $centers_data[$i]['actual_events'] = $count_select_events;
      }

        //Применяем функцию умной фильтрации
        uasort($centers_data, 'cmp_function');
        $centers_data = array_values($centers_data);

        return $this->render('main/centers.twig', [
            'centers_data' => $centers_data,
            'mobileDetect'=>$mobileDetector->isMobile(),
            'is_user' => $this->user_id
        ]);
    }


    /**
     * @Route("/books", name="books", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function books()
    {



      $mobileDetector = new MobileDetect;

        return $this->render('main/books.twig', [
            'controller_name' => 'MainController',
            'mobileDetect'=>$mobileDetector->isMobile(),
            'is_user' => $this->user_id
        ]);
    }


    /**
     * @Route("/ways", name="ways", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function ways()
    {

      $mobileDetector = new MobileDetect;

        return $this->render('main/ways.twig', [
            'controller_name' => 'MainController',
            'mobileDetect'=>$mobileDetector->isMobile(),
            'is_user' => $this->user_id
        ]);
    }




    /**
     * @Route("/nosite", name="nosite", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function site404()
    {


      $mobileDetector = new MobileDetect;
      throw $this->createNotFoundException();
        return $this->render('subdomains/error404.twig', [

        ]);
    }
}
