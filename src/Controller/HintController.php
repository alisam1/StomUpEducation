<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use App\Repository\EventsRepository;
use App\Repository\EventTypeRepository;
use App\Repository\EventWayRepository;
use App\Repository\LectorsRepository;
use App\Services\UsersService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/** API для подскзок
 * @Route("/hint", methods={"POST"}, name="hint")
 */
class HintController extends AbstractController
{

  /**
   * @Route("/city", name="city")
   */
    public function city(Request $request)
    {



        return $this->render('hint/index.html.twig', [
            'controller_name' => 'HintController',
        ]);
    }


    /**
    * @Route("/event_city", name="event_city")
    */
    public function event_city(Request $request, EventsRepository $eventsRepository){

      $allowCitys = $eventsRepository->get_events_city();

      return new JsonResponse($allowCitys);
    }

    /**
     * @Route("/count_data", name="count_data")
     */
      public function count_data(LectorsRepository $lectorsRepository, EventsRepository $eventsRepository, UsersService $userService)
      {


        if( $userService->is_login() ){

          $my_id = $userService->is_login()->id;

          $user_type = $userService->is_login()->type;
        //Массив количественных значений
        $count_data = [
          'lectors_count'=> count($lectorsRepository->get_user_lectors($my_id)),
          'events_count'=> count($eventsRepository->get_user_events($my_id))
        ];

        return $this->json($count_data);

      } else {
        return $this->render('hint/index.html.twig', [
            'controller_name' => 'HintController',
        ]);
      }


      }


      /** HINT для возврата найденных лекторов
       * @Route("/lector", name="lector")
       */
        public function lector(LectorsRepository $lectorsRepository, EventsRepository $eventsRepository, UsersService $userService, Request $request)
        {

          $find_str = $request->request->get('lector');


          $ifind = $lectorsRepository->get_like_lector($find_str);

          return $this->json($ifind);


        }


}
