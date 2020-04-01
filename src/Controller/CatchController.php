<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UsersService;
use App\Services\UploadService;
use App\Services\PhoneService;
use App\Services\Service;
use App\Services\MapService;
use App\Repository\UsersRepository;
use App\Repository\EventsRepository;
use App\Repository\EventRequestRepository;
use App\Repository\LectorsRepository;
use App\Repository\SitesRepository;
use App\Repository\SitesBannersRepository;
use App\Repository\SitesReviewRepository;
use App\Repository\MainBannersRepository;
use App\Repository\MainAdRepository;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Catch controller
 *
 * @Route("/catch", host="{domain}", methods={"POST"}, defaults={"domain"="mededucation.pro"}, requirements={"domain"="stomup.ru|mededucation.pro|localhost|192.168.1.193|188.225.76.115"})
*/

class CatchController extends AbstractController
{
    /** заглушка
     * @Route("/", name="catch")
     */
    public function index()
    {

        return $this->render('catch/index.html.twig', [
            'controller_name' => 'CatchController',
        ]);
    }

    /** API который ловит регистрацию пользователя
     * @Route("/catch_registration", name="catch_registration")
     *
     */
    public function catch_registration(UsersRepository $userRepository , UsersService $users, Request $request, PhoneService $phoneService)
    {


      if(
        $request->request->get('login') !== null &&
        $request->request->get('password') !== null &&
        $request->request->get('email') !== null &&
        $request->request->get('phone') !== null &&
        $request->request->get('type') !== null &&
        $request->request->get('full_name') !== null
      ){
          $login = $request->request->get('login');
          $pass = md5(md5($request->request->get('password')));
          $email = $request->request->get('email');
          $phone = $phoneService->clear_phone($request->request->get('phone'));
          $salt = $users->make_random_salt();
          $type = $request->request->get('type');
          $full_name = $request->request->get('full_name');
          if($request->request->get('photo') !== null){
          $photo = $request->request->get('photo');
        } else {
          $photo = '/img/nophoto.jpg';
        }
        $photo = json_encode($photo);

          $testUser = $userRepository->check_user($phone);

        } else {
          die('Fail');
        }

      if(count($testUser) == 0){

        if($type == 2) //если слушатель
        {
          $photo = '/uploads/avatars-02.png';
          $email = '';
          $worker_position = $request->request->get('worker_position');
          $worker_city = $request->request->get('worker_city');


          $userRepository->create_user($login,$pass,$email,$phone,$type,$salt,
          $full_name,$worker_position,$worker_city, NULL, NULL, NULL, NULL, NULL, NULL,$photo);


        } elseif ($type == 1) //если центер
         {
           $photo = '/uploads/avatars-01.png';
           $inn = $request->request->get('inn');
           $kpp = $request->request->get('kpp');
           $ogrn = $request->request->get('ogrn');
           $jur_name = $request->request->get('jur_name');
           $jur_address[] = $request->request->get('jur_address');
           $fiz_address[] = $request->request->get('fiz_address');


          $userRepository->create_user($login,$pass,$email,$phone,$type,$salt,
        $full_name,NULL,NULL,$inn,$kpp,$ogrn,$jur_name,$jur_address,$fiz_address,$photo);
        }

        $testUser = $userRepository->login_check($phone,$pass);
        $resp = json_decode($testUser);
        $user_id = $resp[0]->id;

        //Переключатель для прохождения теста без сессии
        //PHPunit почему то тупит на сессиях :(
        if($request->request->get('tester_id') === null){
        $session = new Session();
        $session->set('f22', $resp[0]);
        }


        return new Response('ok');
      } else {
        return new Response('already');
      }

    }

    /** API который ловит логин пользователя
     * @Route("/catch_login", name="catch_login")
     */
    public function catch_login(UsersRepository $userRepository , UsersService $users, Request $request, PhoneService $phoneService)
    {



      if( $request->request->get('login') !== null &&
          $request->request->get('password') !== null
        ){
      $phone = $phoneService->clear_phone($request->request->get('login'));


      $pass = md5(md5($request->request->get('password')));

      $testUser = $userRepository->login_check($phone,$pass);

      }
      else {
        die('Fail');
      }

      if($testUser != 'Fail'){

        $resp = json_decode($testUser);

        $user_id = $resp[0]->id;

        //Блок для прохождения теста
          if($request->request->get('tester_id') === null){
            $session = new Session();
            $session->set('f22', $resp[0]);
              }

      return new Response('ok');
    } else {
      return new Response('auth_fail');
    }

    }


    /** API который ловит создание мероприятия
     * @Route("/catch_event", name="catch_event")
     */
    public function catch_event(UsersRepository $userRepository , UsersService $userService, EventsRepository $eventsRepository, Request $request, UploadService $uploadService)
    {

      //Блок для прохождения теста без сессии
      if($request->request->get('tester_id') === null){
        $user_id = $userService->is_login()->id;
      } else {
        $user_id = $request->request->get('tester_id');
      }

      //Переменные
      $event_name = $request->request->get('events_name');
      //Проверка на существование подобного имени
      $testEvent = $eventsRepository->check_event($event_name);
      //Если подобное имя существует - возвращаем already
      if(count($testEvent) >= 1){
        return new Response('already');
      }

      $event_type = $request->request->get('type');

      //инпуты нужно будет собирать в отдельный массив
      $event_way = explode(',',$request->request->get('my_hidden'));
      // $event_way = json_encode($event_way);//json

      $event_city = $request->request->get('events_city'); //city
      $event_address = $request->request->get('events_address'); //addr

      //Дата и время начала
      $events_date_start = $request->request->get('data_start');
      $events_time_start = $request->request->get('time_start');
      $events_datetime_start = date('Y-m-d H:i:s', strtotime($events_date_start.$events_time_start)); //datetime for mysql

      //Дата и время окончания
      $events_date_stop = $request->request->get('data_finish');
      $events_time_finish = $request->request->get('time_finish');
      $events_datetime_finish = date('Y-m-d H:i:s', strtotime($events_date_stop.$events_time_finish)); //datetime for mysql

      //Лекторы
      $lectors_id = explode(',',$request->request->get('my_hidden_lectors'));
      // $lectors_id = json_encode($lectors_id);//json



      //Фотографии курса
      //FILE
      $events_photo = ['/img/nophoto.jpg'];
      // тут будет массив из фоточек, нужно будет преобразовать его в json после загрузки
      if( $_FILES['form-photo']['name'][0] != '' ){
          $events_photo = $uploadService->make_many_image($_FILES['form-photo'],'events/photos');
      }

      //Описание курса
      $events_description = $request->request->get('form-textarea');

      //Платный ли курс
      $is_free = $request->request->get('course-pay'); //on
      if(is_null($is_free)){
        $is_free = 0;
      } else {
        $is_free = 1;
      }

      $event_price = (int)$request->request->get('cource-price');

      //Акция
      $event_discount = $request->request->get('cource-free'); //on
      if(is_null($event_discount)){
        $event_discount = 0;
      } else {
        $event_discount = 1;
      }

      $event_discount_percent = (int)$request->request->get('cource-free-percent');

      //Количество балов и Сертификат
      $event_points = $request->request->get('cource-points'); //on
      $event_points_val = (int)$request->request->get('cource-points-val');


      $event_sertificate = $request->request->get('cource-is-sert');


      //Обложка
      $event_main_img = '/img/nophoto.jpg';
      if($_FILES['cover-photo']['name'] != ''){
        //Тут загружаем файл и возвращаем img
        $event_main_img = $uploadService->make_image($_FILES['cover-photo'],'events');
      }

      if(count($testEvent) == 0){
        $eventsRepository->create_event(
              $user_id,$event_name,$event_type,
              $event_way,$event_address, $event_city,
              $events_datetime_start,$events_datetime_finish,
              $lectors_id,$events_photo,$events_description,
              $is_free,$event_price,$event_discount, $event_discount_percent, $event_points_val,
              $event_sertificate, $event_main_img);
        return new Response('ok');
      } else {
        return new Response('already');
      }

    }


    /** API который ловит создание мероприятия
     * @Route("/catch_event_edit", name="catch_event_edit")
     */
    public function catch_event_edit(UsersRepository $userRepository , UsersService $userService, EventsRepository $eventsRepository, Request $request, UploadService $uploadService)
    {

      $user_id = $userService->is_login()->id;

      //Переменные
      //zz
      $event_name = $request->request->get('nameing');
      $event_type = $request->request->get('type_name');

      //инпуты нужно будет собирать в отдельный массив
      // $event_way = explode(',',$request->request->get('my_hidden'));
      $event_way[] = $request->request->get('way_name');
      $event_way = json_encode($event_way);//json

      $event_city = $request->request->get('city'); //city
      $event_address = $request->request->get('address'); //addr

      //Дата и время начала
      $events_date_start = $request->request->get('date_start');
      $events_time_start = $request->request->get('time_start');
      $events_datetime_start = date('Y-m-d H:i:s', strtotime($events_date_start.$events_time_start)); //datetime for mysql

      //Дата и время окончания
      $events_date_stop = $request->request->get('date_end');
      $events_time_finish = $request->request->get('time_end');
      $events_datetime_finish = date('Y-m-d H:i:s', strtotime($events_date_stop.$events_time_finish)); //datetime for mysql

      //Лекторы
      $lectors_id[] = $request->request->get('chooseyour_lector');
      $lectors_id = json_encode($lectors_id);

      //Описание курса
      $events_description = $request->request->get('event_description');

      $event_price = (int)$request->request->get('pricer');

      //Платный ли курс
      if($event_price > 0){
        $is_free = 1;
      } else {
        $is_free = 0;
      }

      //Количество балов и Сертификат
      $event_points = 0;

      $event_points_val = (int)$request->request->get('points');
      if($event_points_val > 0){
        $event_points = 1;
      }
      $event_sertificate = $request->request->get('sert');
      $event_id = $request->request->get('event_id');

      $event_background_now = $eventsRepository->get_event_by_id($event_id)[0]['event_main_img'];



      //Обложка
      $event_main_img = $event_background_now;
      if($_FILES['background']['name'] != ''){
        //Тут загружаем файл и возвращаем img
        $event_main_img = $uploadService->make_image($_FILES['background'],'events');
      }


        $eventsRepository->update_event($event_id,$event_name,$event_type,$event_way,$event_city,$event_address, $events_datetime_start, $events_datetime_finish, $lectors_id, $events_description, $event_price, $is_free, $event_points_val, $event_sertificate, $event_main_img);


        return new Response('ok');

    }


    /** API который ловит нового лектора
     * @Route("/catch_lector", name="catch_lector")
     */
    public function catch_lector(UploadService $uploadService, LectorsRepository $lectorsRepository, Request $request, PhoneService $phoneService)
    {
      // Если существует файл
      if(isset($_FILES) && isset($_FILES['new_lector_photo']) && $_FILES['new_lector_photo']['name'] != ''){
        //перезаписываем в переменную файл по его имени
        $image = $_FILES['new_lector_photo'];
        //используем сервис загрузки картинок для того что бы положить картинку по адрессу
        //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
        $upload_photo = $uploadService->make_image($image,'lectors');

        //Если все ок
        if($upload_photo != 'Fail' && $upload_photo != 'FailSize'){
          $photo = $upload_photo;
        } else {
          //Если все не ок - ставим стандартный аватар
          $photo = '/img/nophoto.jpg';
        }
      } //Если файл с фоткой не отправляли
       else {
          $photo = '/img/nophoto.jpg';
      }

      $full_name = $request->request->get('full_name');
      $worker_position = $request->request->get('worker_position');
      $phone = $phoneService->clear_phone($request->request->get('lector_phone'));
      $email = $request->request->get('lector_email');
      $about = $request->request->get('events-lector__textarea');
      $in_center[] = $request->request->get('in_center');

      //проверяем есть ли лектор с таким иминем
      $testLector = $lectorsRepository->check_lector($full_name);

      //Если нету- создаем и возвращаем 'ok', иначе - возвращаем False
      if(count($testLector) == 0){
        $lectorsRepository->create_lector($full_name,$worker_position,$phone,$email,$photo,$in_center,$about);
        return new Response('ok');
      } else {
        return new Response('already');
      }


    }


    /** API который ловит нового лектора
     * @Route("/catch_lector/callback", name="catch_lector_callback")
     */
    public function catch_lector_callback(UploadService $uploadService, LectorsRepository $lectorsRepository, Request $request, PhoneService $phoneService, UsersService $userService)
    {
      // Если существует файл
      if(isset($_FILES) && isset($_FILES['new_lector_photo']) && $_FILES['new_lector_photo']['name'] != ''){
        //перезаписываем в переменную файл по его имени
        $image = $_FILES['new_lector_photo'];
        //используем сервис загрузки картинок для того что бы положить картинку по адрессу
        //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
        $upload_photo = $uploadService->make_image($image,'lectors');

        //Если все ок
        if($upload_photo != 'Fail' && $upload_photo != 'FailSize'){
          $photo = $upload_photo;
        } else {
          //Если все не ок - ставим стандартный аватар
          $photo = '/img/nophoto.jpg';
        }
      } //Если файл с фоткой не отправляли
       else {
          $photo = '/img/nophoto.jpg';
      }

      $my_id = $userService->is_login()->id;

      $full_name = $request->request->get('full_name');
      $worker_position = $request->request->get('worker_position');
      $phone = $phoneService->clear_phone($request->request->get('lector_phone'));
      $email = $request->request->get('lector_email');
      $about = $request->request->get('events-lector__textarea');
      $in_center[] = $my_id;

      //проверяем есть ли лектор с таким иминем
      $testLector = $lectorsRepository->check_lector($full_name);

      //Если нету- создаем и возвращаем 'ok', иначе - возвращаем False
      if(count($testLector) == 0){
        $create_lector = $lectorsRepository->create_lector($full_name,$worker_position,$phone,$email,$photo,$in_center,$about);

        $arrCallback = [
          'full_name'=>$full_name,
          'worker_position'=>$worker_position,
          'phone'=>$phone,
          'email'=>$email,
          'photo'=>$photo,
          'id'=>$create_lector
        ];

        return new JsonResponse($arrCallback);
      } else {
        return new Response('already');
      }


    }


    /** API который ловит нового лектора
     * @Route("/catch_lector_edit", name="catch_lector_edit")
     */
    public function catch_lector_edit(UploadService $uploadService, LectorsRepository $lectorsRepository, Request $request , PhoneService $phoneService)
    {

      $photo = '/img/nophoto.jpg';

      $lector_ids = $request->request->get('lector_ids');
      //проверяем есть ли лектор с таким иминем
      $testLector = $lectorsRepository->find_lector_by_id($lector_ids);

      $center_user_already = json_decode($testLector[0]['in_centers']);

      //Если этот центр уже есть в массиве лектора
      if( in_array($request->request->get('in_center') , $center_user_already) ){
        $in_center = $center_user_already;
      } //Если его нету то подставляем из POST
       else {
         $in_center = $center_user_already;
         $in_center[] = $request->request->get('in_center');
      }


      //Если есть фотка и фотка не ноль - подставляем предидущую фотку
      if(isset($testLector[0]['photo'])){
        if($testLector[0]['photo'] != null ){
          $photo = $testLector[0]['photo'];
        } else {
          $photo = '/img/nophoto.jpg';
        }
      }

      // Если существует файл
      if(isset($_FILES) && isset($_FILES['new_lector_photo']) && $_FILES['new_lector_photo']['name'] != ''){
        //перезаписываем в переменную файл по его имени
        $image = $_FILES['new_lector_photo'];
        //используем сервис загрузки картинок для того что бы положить картинку по адрессу
        //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
        $upload_photo = $uploadService->make_image($image,'lectors');

        //Если все ок
        if($upload_photo != 'Fail' && $upload_photo != 'FailSize'){
          $photo = $upload_photo;
        }
      }

      $full_name = $request->request->get('full_name');
      $worker_position = $request->request->get('worker_position');
      $phone = $phoneService->clear_phone($request->request->get('lector_phone'));
      $email = $request->request->get('lector_email');

      //Обновляем лектора
      $lector_update = $lectorsRepository->lector_update($lector_ids, $full_name,$worker_position,$phone,$email,$photo,$in_center);

      if($lector_update == 'ok'){
        return new Response('ok');
      } else {
        return new Response('Fail');
      }


    }


     /** API который ловит редактирование профиля
      * @Route("/catch_profile_edit", name="catch_profile_edit")
      */
      public function catch_profile_edit(UploadService $uploadService, UsersService $userService, UsersRepository $userRepository , Request $request, PhoneService $phoneService){

        // Если существует файл
        if(isset($_FILES) && isset($_FILES['profile_photo'])){

          //перезаписываем в переменную файл по его имени
          $image = $_FILES['profile_photo'];
          //используем сервис загрузки картинок для того что бы положить картинку по адрессу
          //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
          $upload_photo = $uploadService->make_image($image,'profiles');

          //Если все ок
          if($upload_photo != 'Fail' && $upload_photo != 'FailSize'){

            //Начинаем писать переменные
            $full_name = $request->request->get('profile_name');
            $photo = $upload_photo;
            $phone = $phoneService->clear_phone($request->request->get('profile_phone'));
            $email = $request->request->get('profile_mail');
            $inn = $request->request->get('profile_inn');
            $kpp = $request->request->get('profile_kpp');
            $jur_name = $request->request->get('profile_ur');
            $jur_address[] = $request->request->get('profile_urad');
            $fiz_address[] = $request->request->get('profile_factad');

            //Данные уникальны для слушателя
            $worker_position = $request->request->get('worker_position');
            $worker_city = $request->request->get('worker_city');

            //Получаем id Юзера из под которого работаем
            $user_id = $userService->is_login()->id;

            //Определяем тип пользователя
            $user_type = $userService->is_login()->type;

            //Если пользователь это центр
            if($user_type == '1'){
            //Вызываем репозиторий USER для обновления данных
            $update_user = $userRepository->update_user_center(
              $user_id,$full_name,$photo,
              $phone,$email,$inn,
              $kpp,$jur_name,$jur_address,$fiz_address);

              return new Response('ok');
            }
            //Если пользователь это слушатель
            elseif ($user_type == '2') {

              $update_user = $userRepository->update_user_listener(
                $user_id,$full_name,$photo,
                $phone,$email, $worker_position,
                $worker_city
              );

               return new Response('ok');
            }

          }
          //Если слишком большой размер файла
           elseif ($upload_photo == 'FailSize')
           {
            return new Response('FailSize');
          }
          //Если вообще все сломалось (возможно не хватило прав для записи в каталог)
           elseif( $upload_photo == 'Fail' )
           {
            return new Response('Fail');
          }


          return new Response('ok');
        }
        //Если не существует файла
         else {

           //Начинаем писать переменные
           $full_name = $request->request->get('profile_name');
           // $photo = $upload_photo;
           $phone = $phoneService->clear_phone($request->request->get('profile_phone'));
           $email = $request->request->get('profile_mail');
           $inn = $request->request->get('profile_inn');
           $kpp = $request->request->get('profile_kpp');
           $jur_name = $request->request->get('profile_ur');
           $jur_address[] = $request->request->get('profile_urad');
           $fiz_address[] = $request->request->get('profile_factad');

           //Данные уникальны для слушателя
           $worker_position = $request->request->get('worker_position');
           $worker_city = $request->request->get('worker_city');

           //Получаем id Юзера из под которого работаем
           $user_id = $userService->is_login()->id;


           //Определяем тип пользователя
           $user_type = $userService->is_login()->type;

           //Устанавливаем старое фото
           $userData = $userRepository->find_by_id($user_id);
           $photo = $userData[0]['photo_link'];

           //Если пользователь это центр
           if($user_type == '1'){
           //Вызываем репозиторий USER для обновления данных
           $update_user = $userRepository->update_user_center(
             $user_id,$full_name,$photo,
             $phone,$email,$inn,
             $kpp,$jur_name,$jur_address,$fiz_address);

             return new Response('ok');
           }
           //Если пользователь это слушатель
           elseif ($user_type == '2') {
             $update_user = $userRepository->update_user_listener(
               $user_id,$full_name,$photo,
               $phone,$email, $worker_position,
               $worker_city
             );

             return new Response('ok');
           }
        }

      }


      /** API который создает сайты
       * @Route("/catch_new_site", name="catch_new_site")
       */
       public function catch_new_site(UploadService $uploadService, UsersService $userService, UsersRepository $userRepository , Request $request, PhoneService $phoneService, SitesRepository $siteRepository, MapService $mapService ){


         //Получаем id Юзера из под которого работаем
         $user_id = $userService->is_login()->id;


         // проверяем есть ли у данного пользователя сайт
          if($siteRepository->is_site_exist($user_id)){
            return new Response('Fail');
          } else {
            //Если сайта у пользователя пока нету, собраем данные и создаем ему сайт

            //Изображения:

            // Если существует файл LOGO
            if(isset($_FILES) && isset($_FILES['site_main_logo']) && $_FILES['site_main_logo']['name'] != ''){
              //перезаписываем в переменную файл по его имени
              $image = $_FILES['site_main_logo'];
              //используем сервис загрузки картинок для того что бы положить картинку по адрессу
              //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
              $upload_logo = $uploadService->make_image($image,'sites/logo');

              //Если все ок
              if($upload_logo != 'Fail' && $upload_logo != 'FailSize'){
                $site_logo = $upload_logo;
              }
            } else {
                $site_logo = '/img/nophoto.jpg';
            }

            // Если существует файл About
            if(isset($_FILES) && isset($_FILES['about-photo']) && $_FILES['about-photo']['name'][0] != ''){
              //перезаписываем в переменную файл по его имени
              $image = $_FILES['about-photo'];
              //используем сервис загрузки картинок для того что бы положить картинку по адрессу
              //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
              $upload_about = $uploadService->make_image($image,'sites');

              //Если все ок
              if($upload_about != 'Fail' && $upload_about != 'FailSize'){
                $photo_about = $upload_about;
              }
            } else {
              $photo_about = '/img/nophoto.jpg';
            }

            //Изображения-END.

            //Переменные
            $site_url = $request->request->get('site_url');
            $site_phone = $request->request->get('site_phone');
            $site_email = $request->request->get('site_email');
            $site_name = $request->request->get('site_name');
            $site_about_text = $request->request->get('about_textarea');
            $site_station = $request->request->get('site_station');
            $site_worktime_from = $request->request->get('site_worktime_from');
            $site_worktime_to = $request->request->get('site_worktime_to');

            $site_city = $request->request->get('site_city');
            $site_addr = $request->request->get('site_addr');
            $site_seo_title = $request->request->get('site_seo_title');
            $site_seo_description = $request->request->get('site_seo_description');
            $site_seo_ya = $request->request->get('site_seo_ya');
            $site_seo_ga = $request->request->get('site_seo_ga');

            //Формируем время работы
            $site_worktime = $site_worktime_from.' - '.$site_worktime_to.'';
            //Формируем верную последовательнсоть адресса
            $addr_pack = $site_city.', '.$site_addr.'';

            //Создаем координаты для карты
            $map_cord = $mapService->get_cord_by_yandex($addr_pack);


            //Выполняем репозиторий на создание сайта
            $siteRepository->create_site($user_id, $site_url , $site_phone, $site_email, $map_cord, $site_seo_title, $site_seo_description, $site_seo_ya, $site_seo_ga, $site_logo, $site_name, $site_station, $site_worktime,$site_city , $site_addr, $site_about_text, $photo_about);

            return new Response('ok');
          }


       }



       /** API который обновляет сайты
        * @Route("/catch_site_edit", name="catch_site_edit")
        */
        public function catch_site_edit(UploadService $uploadService, UsersService $userService, UsersRepository $userRepository , Request $request, PhoneService $phoneService, SitesRepository $siteRepository, MapService $mapService ){

          //Получаем id Юзера из под которого работаем
          $user_id = $userService->is_login()->id;

          // проверяем есть ли у данного пользователя сайт
           if($siteRepository->is_site_exist($user_id)){

             //Подгружаем данные сайта
             $site_data = $siteRepository->get_site_data($user_id)[0];


              // Если существует файл LOGO
              if(isset($_FILES) && isset($_FILES['site_main_logo']) && $_FILES['site_main_logo']['name'] != ''){
                //перезаписываем в переменную файл по его имени
                $image = $_FILES['site_main_logo'];
                //используем сервис загрузки картинок для того что бы положить картинку по адрессу
                //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
                $upload_logo = $uploadService->make_image($image,'sites/logo');

                //Если все ок
                if($upload_logo != 'Fail' && $upload_logo != 'FailSize'){
                  $site_logo = $upload_logo;

                  //Удаляем предидущую версию лого
                  if($site_data['site_main_logo'] != '' && $site_data['site_main_logo'] != "/img/nophoto.jpg"){
                    unlink($_SERVER['DOCUMENT_ROOT'].$site_data['site_main_logo']);
                  }


                } elseif($upload_logo == 'FailSize') {
                  return new Response('FailSize');
                } elseif ($upload_logo == 'Fail') {
                  return new Response('Fail');
                }

              } else {
                  $site_logo = $site_data['site_main_logo'];
              }



              // Если существует файл About
              if(isset($_FILES) && isset($_FILES['about-photo']) && $_FILES['about-photo']['name'] != ''){
                //перезаписываем в переменную файл по его имени
                $image = $_FILES['about-photo'];
                //используем сервис загрузки картинок для того что бы положить картинку по адрессу
                //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
                $upload_about = $uploadService->make_image($image,'sites');

                //Если все ок
                if($upload_about != 'Fail' && $upload_about != 'FailSize'){
                  $photo_about = $upload_about;

                  //Удаляем предидущую версию лого
                  if($site_data['site_info_logo'] != ''){
                    unlink($_SERVER['DOCUMENT_ROOT'].$site_data['site_info_logo']);
                  }
                }
                elseif($upload_logo == 'FailSize') {
                  return new Response('FailSize');
                } elseif ($upload_logo == 'Fail') {
                  return new Response('Fail');
                }


              } else {
                $photo_about = $site_data['site_info_logo'];
              }


              //Изображения-END.

              //Переменные
              $site_url = $request->request->get('site_url');
              $site_phone = $request->request->get('site_phone');
              $site_email = $request->request->get('site_email');
              $site_name = $request->request->get('site_name');
              $site_about_text = $request->request->get('about_textarea');
              $site_station = $request->request->get('site_station');
              $site_worktime_from = $request->request->get('site_worktime_from');
              $site_worktime_to = $request->request->get('site_worktime_to');

              $site_city = $request->request->get('site_city');
              $site_addr = $request->request->get('site_addr');
              $site_seo_title = $request->request->get('site_seo_title');
              $site_seo_description = $request->request->get('site_seo_description');
              $site_seo_ya = $request->request->get('site_seo_ya');
              $site_seo_ga = $request->request->get('site_seo_ga');

              //Формируем время работы
              $site_worktime = $site_worktime_from.' - '.$site_worktime_to.'';
              //Формируем верную последовательнсоть адресса
              $addr_pack = $site_city.', '.$site_addr.'';

              //Создаем координаты для карты
              $map_cord = $mapService->get_cord_by_yandex($addr_pack);

              //Выполняем репозиторий на создание сайта
              $siteRepository->update_site_data($user_id, $site_url , $site_phone, $site_email, $map_cord, $site_seo_title, $site_seo_description, $site_seo_ya, $site_seo_ga, $site_logo, $site_name, $site_station, $site_worktime,$site_city , $site_addr, $site_about_text, $photo_about);

          return new Response('ok');

        } else {
          return new Response('Fail');
        }

        }


        /** API который создает новый баннер
         * @Route("/catch_create_new_banner", name="catch_create_new_banner")
         */
        public function create_new_banner(SitesBannersRepository $siteBannersRepository, UsersService $userService, SitesRepository $sitesRepository){

          if( $userService->is_login() ){
            $user_id = $userService->is_login()->id;

            $get_site_id = $sitesRepository->is_site_exist($user_id);


            if($get_site_id){
            $siteBannersRepository->create_banner($get_site_id);

            return new Response('ok');
          } else {
            return new Response('FailSiteExist');
          }

          } else {
            return new Response('Fail');
          }

        }


        /** API который удаляет баннер
         * @Route("/catch_delete_banner", methods={"POST"}, name="catch_delete_banner")
         */
        public function delete_banner(SitesBannersRepository $siteBannersRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository){

          if( $userService->is_login() ){
            $user_id = $userService->is_login()->id;
            $get_site_data = $sitesRepository->get_site_data($user_id);


            $site_id = $get_site_data[0]['id'];
            $site_owner_id = $get_site_data[0]['user_id'];

            $banner_id = $request->request->get('banner_id');


            if($user_id == $site_owner_id){
            $siteBannersRepository->delete_banner_by_id($banner_id);

            return new Response('ok');
            }
            else {
              return new Response('FailAccess');
            }


          } else {
            return new Response('Fail');
          }

        }


        /** API который обновляет баннер
         * @Route("/catch_update_banner", name="catch_update_banner")
         */
        public function update_banner(SitesBannersRepository $siteBannersRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository, UploadService $uploadService){

          if( $userService->is_login() ){
            $user_id = $userService->is_login()->id;
            $get_site_data = $sitesRepository->get_site_data($user_id);



            $site_id = $get_site_data[0]['id'];
            $site_owner_id = $get_site_data[0]['user_id'];

            $banner_id = $request->request->get('banner_id');
            $banner_zag = $request->request->get('banner_zag');
            $banner_link = $request->request->get('banner_link');
            $banner_descr = $request->request->get('banner_descr');
            $banner_btn_text = $request->request->get('banner_btn_text');


            if($user_id == $site_owner_id){

              $banner_data = $siteBannersRepository->get_banners_by_id($site_id);

              // Если существует файл site_banner
              if(isset($_FILES) && isset($_FILES['site_banner']) && $_FILES['site_banner']['name'] != ''){
                //перезаписываем в переменную файл по его имени
                $image = $_FILES['site_banner'];
                //используем сервис загрузки картинок для того что бы положить картинку по адрессу
                //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
                $upload_banner = $uploadService->make_image($image,'sites/banners');

                //Если все ок
                if($upload_banner != 'Fail' && $upload_banner != 'FailSize'){
                  $photo_banner = $upload_banner;

                  // //Удаляем предидущую версию лого
                  if($banner_data[0]['img'] != '' && $banner_data[0]['img'] != 'image'){
                    unlink($_SERVER['DOCUMENT_ROOT'].$banner_data[0]['img']);
                  }
                }
                elseif($upload_logo == 'FailSize') {
                  return new Response('FailSize');
                } elseif ($upload_logo == 'Fail') {
                  return new Response('Fail');
                }


              } else {
                $photo_banner = $banner_data[0]['img'];
              }


            $siteBannersRepository->update_banner($banner_id,$banner_zag,$banner_link,$banner_descr,$banner_btn_text,$photo_banner);

            return new Response('ok');
            }
            else {
              return new Response('FailAccess');
            }


          } else {
            return new Response('Fail');
          }

        }



        /** API который создает новый отзыв
         * @Route("/catch_new_review", name="catch_new_review")
         */
        public function catch_new_review(SitesReviewRepository $sitesReviewRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository){

          if( $userService->is_login() ){
            $user_id = $userService->is_login()->id;

            $get_site_id = $sitesRepository->is_site_exist($user_id);


            if($get_site_id){
              $review_name = $request->request->get('review_name');
              $review_position = $request->request->get('review_position');
              $review_texrarea = $request->request->get('review_texrarea');

            $sitesReviewRepository->make_new_review($get_site_id,$review_name,$review_position,$review_texrarea);

            return new Response('ok');
          } else {
            return new Response('FailSiteExist');
          }

          } else {
            return new Response('Fail');
          }

        }


        /** API который удаляет отзыв
         * @Route("/catch_delete_review", name="catch_delete_review")
         */
        public function catch_delete_review(SitesReviewRepository $sitesReviewRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository){

          if( $userService->is_login() ){
            $user_id = $userService->is_login()->id;

            $review_id = $request->request->get('review_id');

            $sitesReviewRepository->delete_review_by_id($review_id);

            return new Response('ok');

          } else {
            return new Response('Fail');
          }

        }


        /** AdminAPI который создает баннеры
         * @Route("/catch_create_main_banner", name="catch_create_main_banner")
         */
         public function catch_create_main_banner(MainBannersRepository $siteBannersRepository, UsersService $userService, SitesRepository $sitesRepository){

           if( $userService->is_login() ){
             $user_id = $userService->is_login()->id;
             $user_type = $userService->is_login()->type;



             if($user_type == '66'){
             $siteBannersRepository->create_banner();

             return new Response('ok');
           } else {
             return new Response('AccessError');
           }

           } else {
             return new Response('Fail');
           }

         }



         /** AdminAPI который изменяет баннер
         * @Route("/catch_update_main_banner", name="catch_update_main_banner")
         */
          public function catch_update_main_banner(MainBannersRepository $siteBannersRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository, UploadService $uploadService){

            if( $userService->is_login() ){
              $user_id = $userService->is_login()->id;
              $user_type = $userService->is_login()->type;

              $banner_id = $request->request->get('banner_id');
              $banner_zag = $request->request->get('banner_zag');
              $banner_link = $request->request->get('banner_link');
              $banner_descr = $request->request->get('banner_descr');
              $banner_btn_text = $request->request->get('banner_btn_text');
              $banner_priority = $request->request->get('banner_priority');


              if($user_type == '66'){

                //Получаем данные по данному банеру в режиме id
                $banner_data = $siteBannersRepository->get_banner_by_id($banner_id);

                // Если существует файл site_banner
                if(isset($_FILES) && isset($_FILES['site_banner']) && $_FILES['site_banner']['name'] != ''){
                  //перезаписываем в переменную файл по его имени
                  $image = $_FILES['site_banner'];
                  //используем сервис загрузки картинок для того что бы положить картинку по адрессу
                  //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
                  $upload_banner = $uploadService->make_image($image,'sites/banners');

                  //Если все ок
                  if($upload_banner != 'Fail' && $upload_banner != 'FailSize'){
                    $photo_banner = $upload_banner;

                    // //Удаляем предидущую версию лого
                    if($banner_data[0]['img'] != '' && $banner_data[0]['img'] != 'image'){
                      unlink($_SERVER['DOCUMENT_ROOT'].$banner_data[0]['img']);
                    }
                  }
                  elseif($upload_logo == 'FailSize') {
                    return new Response('FailSize');
                  } elseif ($upload_logo == 'Fail') {
                    return new Response('Fail');
                  }


                } else {
                  $photo_banner = $banner_data[0]['img'];
                }


              $siteBannersRepository->update_banner($banner_id,$banner_zag,$banner_link,$banner_descr,$banner_btn_text,$photo_banner,$banner_priority);

              return new Response('ok');
              }
              else {
                return new Response('FailAccess');
              }


            } else {
              return new Response('Fail');
            }

          }



          /** AdminAPI который удаляет главный баннер
           * @Route("/catch_delete_main_banner", name="catch_delete_main_banner")
           */
          public function catch_delete_main_banner(MainBannersRepository $siteBannersRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository){

            if( $userService->is_login() ){
              $user_id = $userService->is_login()->id;
              $user_type = $userService->is_login()->type;

              $banner_id = $request->request->get('banner_id');

              if($user_type == '66'){
              $siteBannersRepository->delete_banner_by_id($banner_id);

              return new Response('ok');
              }
              else {
                return new Response('FailAccess');
              }


            } else {
              return new Response('Fail');
            }

          }



          /** AdminAPI который изменяет рекламу
          * @Route("/catch_update_main_ad", name="catch_update_main_ad")
          */
           public function catch_update_main_ad(MainAdRepository $mainAdRepository, Request $request, UsersService $userService, SitesRepository $sitesRepository, UploadService $uploadService){

             if( $userService->is_login() ){
               $user_id = $userService->is_login()->id;
               $user_type = $userService->is_login()->type;

               $links = $request->request->get('banner_link');
               $css_rule = $request->request->get('ta_css');
               $block_key = $request->request->get('this_ad_key');


               if($user_type == '66'){

                 //Получаем данные по данному банеру в режиме id
                 $banner_data = $mainAdRepository->get_ad_by_key($block_key);

                 // Если существует файл site_banner
                 if(isset($_FILES) && isset($_FILES['ad_img']) && $_FILES['ad_img']['name'] != ''){
                   //перезаписываем в переменную файл по его имени
                   $image = $_FILES['ad_img'];
                   //используем сервис загрузки картинок для того что бы положить картинку по адрессу
                   //сервис вернет строкой путь к файлу, либо вернет Fail , либо FailSize
                   $upload_banner = $uploadService->make_image($image,'ads');

                   //Если все ок
                   if($upload_banner != 'Fail' && $upload_banner != 'FailSize'){
                     $photo_banner = $upload_banner;

                     // //Удаляем предидущую версию лого
                     if($banner_data[0]['img'] != '' && $banner_data[0]['img'] != 'image'){
                       if(file_exists($_SERVER['DOCUMENT_ROOT'].$banner_data[0]['img'])){
                       unlink($_SERVER['DOCUMENT_ROOT'].$banner_data[0]['img']);
                       }
                     }
                   }
                   elseif($upload_logo == 'FailSize') {
                     return new Response('FailSize');
                   } elseif ($upload_logo == 'Fail') {
                     return new Response('Fail');
                   }


                 } else {
                   $photo_banner = $banner_data[0]['img'];
                 }


               $mainAdRepository->update_ad_by_key($block_key,$photo_banner,$links,$css_rule);

               return new Response('ok');
               }
               else {
                 return new Response('FailAccess');
               }


             } else {
               return new Response('Fail');
             }

           }



           /** API который ловит заяки пользователя
           * @Route("/catch_event_request", name="catch_event_request")
           */
            public function catch_event_request(Request $request, UsersService $userService, EventRequestRepository $eventRequestRepository, EventsRepository $eventsRepository, UsersRepository $userssRepository){

              if( $userService->is_login() ){
                $user_id = $userService->is_login()->id;
                $event_id = $request->request->get('event_id');
                $center_id = $eventsRepository->get_event_by_id($event_id)[0]['user_id'];

                $user_data = $userssRepository->find_by_id($user_id);
                if(count($user_data) > 0){
                  $full_name = $user_data[0]['full_name'];
                  $phone = $user_data[0]['phone'];
                  $email = $user_data[0]['email'];
                  $eventRequestRepository->create_event_request_by_user($event_id, $user_id, $center_id, $full_name, $phone, $email);
                } else {
                  return new Response('FailAuth');
                }

              }
              else {

                $event_id = $request->request->get('event_id');
                $center_id = $eventsRepository->get_event_by_id($event_id)[0]['user_id'];
                $full_name = $request->request->get('full_name');
                $city = $request->request->get('city');
                $phone = $request->request->get('phone');
                $email = $request->request->get('email');
                $comment = $request->request->get('comment');

                $eventRequestRepository->create_event_request_by_noname($event_id, $center_id, $full_name, $city, $phone, $comment, $email);

              }

              return new Response('ok');

            }



}
