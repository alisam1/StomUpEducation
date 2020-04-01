<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventsRepository;
use App\Repository\LectorsRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Detection\MobileDetect;
use App\Services\UsersService;

class LectorsController extends AbstractController
{


    /**
     * @Route("/cabinet/lectors", name="cabinet_lectors", host="{domain}", defaults={"domain"="mededucation.pro"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function cabinet_lectors(LectorsRepository $lectorsRepository, UsersService $userService, EventsRepository $eventsRepository, UsersRepository $userRepository)
    {
      $mobileDetector = new MobileDetect;


      // проверка залогинен ли пользователь
      if( $userService->is_login() ){

        //Выключаем досутп для слушателя
        if( $userService->is_login()->type == 2 ){
          return $this->redirect('/');
        }

        $my_id = $userService->is_login()->id;
        $lectors_list = $lectorsRepository->get_user_lectors($my_id);
        $userData = $userRepository->find_by_id($my_id);
        $event_type = $eventsRepository->get_events_type();
        $event_way = $eventsRepository->get_events_way();

        for ($i=0; $i < count($lectors_list); $i++) {
          $lector_id = $lectors_list[$i]['id'];
          $my_events = $eventsRepository->json_search_id('lector_id',$lector_id);

          $lectors_list[$i]['events'] = $my_events;
        }




        return $this->render('center/lectors/lectors.twig', [
            'mobileDetect' => $mobileDetector->isMobile(),
            'lectors_list' => $lectors_list,
            'my_id'=>$my_id,
            'event_type'=>$event_type,
            'event_way'=>$event_way,
            'user_data' => $userData[0],
        ]);

      } else {
        return $this->redirect('/');
      }


    }

    /**
     * @Route("/lectors/{lector_id}", name="lector_id", host="{domain}", defaults={"domain"="stomup.ru"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
     */
    public function lector_id($lector_id, LectorsRepository $lectorsRepository)
    {

      $mobileDetector = new MobileDetect;

      $lector_data = $lectorsRepository->get_lector_by_id($lector_id);
      if(count($lector_data) <= 0){
        throw $this->createNotFoundException();
      }
      $lector_events = $lectorsRepository->get_active_events_by_lector($lector_id);


        return $this->render('main/view/lector.view.twig', [
            'lector_data' => $lector_data[0],
            'lector_events' => $lector_events,
            'mobileDetect'=>$mobileDetector->isMobile(),
            'is_user' => $this->user_id
        ]);
    }


}
