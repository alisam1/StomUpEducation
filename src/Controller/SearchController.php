<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UsersService;
use App\Services\SearchService;
use App\Repository\LectorsRepository;
use App\Repository\EventsRepository;
use App\Repository\UsersRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(UsersService $userService, SearchService $searchService, LectorsRepository $lectorsRepository, EventsRepository $eventsRepository)
    {

      $lector_data = $lectorsRepository->find_free_lector_like($_GET['q']);

      $event_data = $eventsRepository->get_events_like($_GET['q']);


      return $this->render('search/index.html.twig', [
          'lectors_data' => $lector_data,
          'event_data' => $event_data
      ]);
        //
        // return $this->render('search/index.html.twig', [
        //     'controller_name' => 'SearchController',
        // ]);
    }

    /**
     * @Route("/cabinet/search", name="cabinet_search")
     */
    public function cabinet_search(UsersService $userService, SearchService $searchService, LectorsRepository $lectorsRepository, EventsRepository $eventsRepository, UsersRepository $userRepository)
    {

      //TEST тут умная система поиска с ошибками

      //Get words array: (it's english names, starting from A,B,C)
// $words = array(
//     'Стоматолог', 'Андрей', 'Васин', 'Kerr', 'Whats'
// );
//
// $ffs = new SearchService($words);
// //Lets pretend, this is user's input:
// $input = $_GET['find'];
//
// //Lets get three most similiar english names:
// $results = $ffs->find($input, 2);
//
// if(count($results) == 0){
//   $results = $ffs->find($searchService->translitIt($input), 2);
// }
//
// dd($results);

      //END-TEST

      if( $userService->is_login() ){
        $user_id = $userService->is_login()->id;
        $user_type = $userService->is_login()->type;

        //Если лекционный центр
        if($user_type == 1){

          $userData = $userRepository->find_by_id($user_id);
          //Ищем лектора
          $lector_data =  $lectorsRepository->find_lector_like($user_id,$_GET['q']);
          //Ищем мероприятие
          $event_data = $eventsRepository->get_my_events_like($user_id,$_GET['q']);

        return $this->render('search/cabinet.search.center.twig', [
            'lectors_data' => $lector_data,
            'event_data' => $event_data,
            'user_data'=>$userData[0]
        ]);

      } elseif ($user_type == 2) {

        $lector_data = $lectorsRepository->find_free_lector_like($_GET['q']);

        $event_data = $eventsRepository->get_events_like($_GET['q']);


        return $this->render('search/cabinet.search.listener.twig', [
            'lectors_data' => $lector_data,
            'event_data' => $event_data
        ]);

      }

      } else {

        return $this->redirect('/');

      }

    }
}
