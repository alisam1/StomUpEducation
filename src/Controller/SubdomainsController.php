<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Detection\MobileDetect;
use App\Repository\SitesRepository;
use App\Repository\SitesReviewRepository;
use App\Repository\EventsRepository;
use App\Repository\EventTypeRepository;
use App\Repository\EventWayRepository;
use App\Repository\LectorsRepository;
use App\Repository\SitesBannersRepository;
use App\Repository\UsersRepository;





/**
 * stomportal.symfony
 * mededucation.pro
 * stomup.ru
 * @Route(host="{subdomain}.stomup.ru", defaults={"subdomain"="rr"}, )
 */
class SubdomainsController extends AbstractController
{

        /**
         * @Route("/", name="subdomains")
         */
        public function index($subdomain, SitesRepository $sitesRepository, EventsRepository $eventsRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, LectorsRepository $lectorsRepository, SitesReviewRepository $sitesReviewRepository, SitesBannersRepository $sitesBannersRepository)
        {


          $site_data = $sitesRepository->get_site_by_domain($subdomain);

          if(count($site_data) > 0){

            $owner_id = $site_data[0]['user_id'];
            $site_id = $site_data[0]['id'];

            //Собираем отзывы
            $site_reviews = $sitesReviewRepository->get_data_by_site($site_id);

            //Получаем все типы и направления мероприятий
            $all_event_type = $eventTypeRepository->get_events_type();
            // $all_event_way = $eventWayRepository->get_events_way();
            $all_event_way = $eventWayRepository->get_user_active_events_way($owner_id);


            //Получаем последних 3х лекторов прикрепленных к этому лекционному центру
            $lectors_list = $lectorsRepository->get_user_lectors_last_three($owner_id);

            for ($i=0; $i < count($lectors_list); $i++) {
              $lector_id = $lectors_list[$i]['id'];
              $my_events_list = $eventsRepository->json_search_id('lector_id',$lector_id);

              $lectors_list[$i]['events'] = $my_events_list;
            }


            $site_banners = $sitesBannersRepository->get_banners_by_id($site_id);

            $work_time = explode(' - ',$site_data[0]['site_info_worktime']);

            if(isset($_GET['fill'])){

              $my_events = $eventsRepository->get_my_events_fill($owner_id, $_GET);

            } else {
              $my_events = $eventsRepository->get_my_events($owner_id);

            }

            $my_events_limit = $eventsRepository->get_my_events_limit($owner_id, 10);

            $all_lectors = $lectorsRepository->get_user_lectors($owner_id);


            return $this->render('subdomains/index.html.twig', [
                'controller_name' => $subdomain,
                'my_events'=>$my_events,
                'my_events_limit'=>$my_events_limit,
                'all_event_type' => $all_event_type,
                'all_event_way' => $all_event_way,
                'all_lectors' => $all_lectors,
                'site_data' => $site_data[0],
                'site_banners'=> $site_banners,
                'work_time' => $work_time,
                'lectors_list' => $lectors_list,
                'site_reviews' => $site_reviews,
            ]);
          }
          else {
            return $this->redirect('http://stomup.ru/nosite');
          }



        }


        /**
         * @Route("/events", name="events_sub")
         */
        public function events_sub($subdomain, SitesRepository $sitesRepository, EventsRepository $eventsRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, LectorsRepository $lectorsRepository, SitesReviewRepository $sitesReviewRepository, SitesBannersRepository $sitesBannersRepository)
        {

          $site_data = $sitesRepository->get_site_by_domain($subdomain);

          if(count($site_data) > 0){

            $owner_id = $site_data[0]['user_id'];
            $site_id = $site_data[0]['id'];

          $mobileDetector = new MobileDetect;

          $all_event_type = $eventTypeRepository->get_events_type();
          $all_event_way = $eventWayRepository->get_events_way();

          if(isset($_GET['fill'])){
            $my_events = $eventsRepository->get_my_events_fill($owner_id, $_GET);
          } else {
            $my_events = $eventsRepository->get_my_events($owner_id);
          }


          $all_lectors = $lectorsRepository->get_all_lectors();

            return $this->render('subdomains/events.twig', [
                'mobileDetect'=>$mobileDetector->isMobile(),
                'all_event_type' => $all_event_type,
                'all_event_way' => $all_event_way,
                'my_events' => $my_events,
                'all_lectors' => $all_lectors,
                'is_user' => $this->user_id,
                'site_data' => $site_data[0],
            ]);

          } else {
            return $this->redirect('http://stomup.ru/nosite');
          }

        }


        /**
         * @Route("/lectors", name="lectors_sub")
         */
        public function lectors_sub($subdomain, SitesRepository $sitesRepository, EventsRepository $eventsRepository, EventTypeRepository $eventTypeRepository, EventWayRepository $eventWayRepository, LectorsRepository $lectorsRepository, SitesReviewRepository $sitesReviewRepository, SitesBannersRepository $sitesBannersRepository, UsersRepository $userRepository)
        {

          $site_data = $sitesRepository->get_site_by_domain($subdomain);

          if(count($site_data) > 0){

            $owner_id = $site_data[0]['user_id'];
            $site_id = $site_data[0]['id'];

            $mobileDetector = new MobileDetect;

            $lectors_list = $lectorsRepository->get_user_lectors($owner_id);

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



                    return $this->render('subdomains/lectors.twig', [
                        'lectors_list' => $lectors_list,
                        'mobileDetect'=>$mobileDetector->isMobile(),
                        'legal_lectors' => $legal_lectors,
                        'is_user' => $this->user_id,
                        'site_data' => $site_data[0],
                    ]);

          } else {
            return $this->redirect('http://stomup.ru/nosite');
          }

        }


}
