<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Detection\MobileDetect;
use App\Services\UsersService;
use App\Services\SocketService;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index(MessagesRepository $messagesRepository, UsersService $userSevice)
    {
      $mobileDetector = new MobileDetect;

      //Проверка залогинен ли клиет
      if( $userService->is_login() ){

      $my_id = $userService->is_login()->id;

      $message_list = $messagesRepository->get_my_message_uniq($my_id);

      $message_arrs = [];

      for ($i=0; $i < count($message_list); $i++) {
        $id = $message_list[$i]['from_user_id'];
        $message_arrs[$id] = $messagesRepository->get_our_message($id,$my_id);
      }


        return $this->render('messages/index.html.twig', [
            'message_list' => $message_list,
            'mobileDetect' => $mobileDetector->isMobile(),
            'my_id' => $my_id,
            'message_arr' => $message_arrs,
        ]);

      } else {
        return $this->redirect('/');
      }
    }


    /**
     * @Route("/messages/{id}", name="messages_view")
     */
    public function view($id = null, MessagesRepository $messagesRepository, SocketService $socketService)
    {
      $session = new Session;

      $my_id = $session->get('f22');

      $get_messages = $messagesRepository->get_our_message($id,$my_id);

      //DOCKER WS SERVER IP
      $server_addr = $socketService->get_addr();

        return $this->render('messages/view.html.twig', [
            'messanges' => $get_messages,
            'my_id'=>$my_id,
            'he_id'=>$id,
            'ip'=>$server_addr
        ]);
    }


    /**
     * @Route("/message/new", name="messages_new")
     */
    public function new( MessagesRepository $messagesRepository,UsersRepository $usersRepository)
    {
      // $from_id = $_POST['from_id'];
      $from_id = $request->request->get('from_id');
      // $to_id = $_POST['to_id'];
      $to_id = $request->request->get('to_id');
      // $msg = $_POST['msg'];
      $msg = $request->request->get('msg');

      $users_data = $usersRepository->find_by_id($to_id);
      $my_data = $usersRepository->find_by_id($from_id);

      $get_messages = $messagesRepository->new_msg($from_id,$to_id,$msg,$users_data,$my_data);

      return new JsonResponse($get_messages);

    }


}
