<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UsersRepository;
use App\Repository\EventsRepository;
use App\Repository\EventRequestRepository;
use App\Repository\EventWayRepository;
use App\Repository\EventTypeRepository;
use App\Repository\LectorsRepository;
use App\Services\UsersService;
use App\Services\UploadService;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

/**
 * API controller
 *
 * @Route("/api", methods={"POST"})
*/

class ApiController extends AbstractController
{

    /** API для получения количества мероприятий объектом
     *  используется для реализации ренедеринга раздела /ways
     * @Route("/count/eventsways", name="count_eventsways")
     */
     public function count_eventsways(EventWayRepository $eventWayRepository, EventsRepository $eventsRepository){

       $data_event_ways = $eventWayRepository->get_events_way();

       $event_obj = [];

       $f = 0;
       for ($i=1; $i < count($data_event_ways)+1; $i++) {
         // выполняем поиск и запись коллекций в массив, который в последствии вернем
         $f++;

         $get_objects = $eventsRepository->json_search_id('event_way',$f);
         $event_obj['waycounter'.$f] = count($get_objects);
       }

       return new JsonResponse($event_obj);

     }

     /** API для создания мероприятия через API
      * @Route("/make/event/{key}", name="make_event")
      */
      public function make_event(EventsRepository $eventsRepository, Request $request, $key, UsersRepository $userRepository){

        /**DOCS
        API ожидает принять:
        1)SALT - по которой будет принимать решение о лекционном центре к которому прикрепить event
        2)name - название мероприятия
        3)event_type - тип мероприятия, в виде int. Получить через метод /api/get/event_types
        4)event_way - направление мероприятия, в виде int(если единичное) или в виде обьекта если несколько направлений. Получить через метод /api/get/event_ways
        5)address - полный адресс мероприятия в виде строки(string), указывать без города
        6)city - город в котором будет проходить мероприятие, в виде строки(string)
        7)start - дата и время начала мероприятия в формате YYYY-MM-DD HH:mm:ii (string)
        8)end - дата и время окончания мероприятия в формате YYYY-MM-DD HH:mm:ii (string)
        9)lector_id - id лектора который будет вести мероприятие, может быть как int, так и object. Получить через закрытый api - /api/get/my/{key}/lectors
        10)events_description - описание мероприятие, может быть пустой строкой
        11)free - должно принимать 0 или 1. 0- бесплатно, 1 - платно.
        12)price - цена мероприятия, в случае если free не 0
        13)rule_point - количество балов которые получит слушатель
        14)sertificate - 0 или 1. 1 - значит будет выдан сертификат о посещении лекции.

        пример на JS
        $.post('/api/make/event/52B2H7NGdEnb',{
          name:'testAPI',
          event_type:1,
          event_way:1,
          address:'Морской пехоты, д.2',
          city:'SPB',
          start:'2021-10-01 10:00:00',
          end:'2021-10-01 12:00:00',
          lector_id:1,
          event_description:'TestAPI',
          free:0,
          price:0,
          rule_point:0,
          sertificate:0,
        },function(data){
          console.log(data);
        });
        */

        $salt = $key;

        $userData = $userRepository->find_user_by_salt($key);

        if( count($userData) > 0 ){

          $user_id = $userData[0]['id'];
          $name = $request->request->get('name');
          $event_type = $request->request->get('event_type');
          $event_way = $request->request->get('event_way');
          if(is_numeric($event_way)){
            $event_way = (array)$event_way;
          }
          $address = $request->request->get('address');
          $city = $request->request->get('city');
          $start = $request->request->get('start');
          $end = $request->request->get('end');
          $lector_id = $request->request->get('lector_id');
          if(is_numeric($lector_id)){
            $lector_id = (array)$lector_id;
          }
          $events_description = $request->request->get('event_description');
          $is_free = $request->request->get('free');
          $price = $request->request->get('price');
          $rule_point = $request->request->get('rule_point');
          $event_sertificate = $request->request->get('sertificate');

          $eventsRepository->create_event($user_id,$name,$event_type,$event_way,$address,$city,$start,$end,$lector_id,NULL,$events_description,$is_free,$price,NULL,NULL,$rule_point,$event_sertificate,'/img/base_event_img.jpg');

          return new JsonResponse('Maked');

      } else {
        return new JsonResponse('WrongApiKey');
      }

        return new Response(TRUE);
      }


      /** API для создания
       * @Route("/make/byxml/event", name="make_event_by_xml")
       */
       public function make_event_by_xml(Request $request, UploadService $uploadService, UsersService $userService, EventsRepository $eventsRepository){

         //Выесняем что за пользователь отправил нам запрос на использование XML-API
         $whoisit = $userService->is_login();


         //Если залогинен но слушатель, то досвидания
         //Если не залогинен, то тоже досвидания
         if($whoisit->type == 2 || !$whoisit){
           return new JsonResponse('AccessError');
         } else {

        $user_id = $whoisit->id;

         //Получаем POST имя файла и ключ для работы с ним
        $xmlfile = $_FILES['filexml'];


        $uploaded_file = $uploadService->upload_api_files($xmlfile,'api/xml/events');

        $simpleXml = simplexml_load_string(file_get_contents($_SERVER['DOCUMENT_ROOT'].$uploaded_file));

        //Пробегаемся парсером по xml
        foreach ($simpleXml->Event as $key => $event) {

          $name = (string)$event->name;
          $event_type = (string)$event->event_type;
          $event_way = (array)$event->event_way;
          $address = (string)$event->address;
          $city = (string)$event->city;
          $start = (string)$event->start;
          $end = (string)$event->end;
          $lector_id = (array)$event->lector_id;
          $events_description = (string)$event->events_description;
          $is_free = (int)$event->free;
          $price = (int)$event->price;
          $rule_point = (int)$event->rule_point;
          $sertificate = (int)$event->sertificate;

  $eventsRepository->create_event($user_id,$name,$event_type,$event_way,$address,$city,$start,$end,$lector_id,NULL,$events_description,$is_free,$price,NULL,NULL,$rule_point,$sertificate,'/img/base_event_img.jpg');
        }


          //Удаляем файл XML
          unlink($_SERVER['DOCUMENT_ROOT'].$uploaded_file);

         return new Response('ok');
          }
       }


      /** API для получения event_ways
       * @Route("/get/event_ways", name="get_events_ways")
       */
       public function get_events_ways(EventWayRepository $eventWayRepository){

         return new JsonResponse($eventWayRepository->get_events_way());
       }

       /** API для получения event_types
        * @Route("/get/event_types", name="get_events_types")
        */
        public function get_events_types(EventTypeRepository $eventTypeRepository){

          return new JsonResponse($eventTypeRepository->get_events_type());
        }

        /** API для получения lectors
         * @Route("/get/my/{key}/lectors", name="get_my_lectors")
         */
         public function get_my_lectors(LectorsRepository $lectorsRepository, UsersRepository $userRepository, $key){
           // dd($key);
           $userData = $userRepository->find_user_by_salt($key);

           if( count($userData) > 0 ){

             $userData = $userData[0];

             if($userData['type'] == '1'){

               $lectorsData = $lectorsRepository->get_user_lectors($userData['id']);

               return new JsonResponse($lectorsData);

             } else {
               return new JsonResponse('WrongUserType');
             }

           } else {
             return new JsonResponse('WrongApiKey');
           }


         }


}
