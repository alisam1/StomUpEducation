<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MainBannersRepository;
use App\Repository\MainAdRepository;
use App\Services\UsersService;

class AdminController extends AbstractController
{

    public function __construct(UsersService $userService)
    {

      //Реализуем защишенную зону только для админов
      if(!$userService->is_login()){
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: /login');
      } elseif ($userService->is_login()->type != '66') {
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: /cabinet');
      }


    }

    /**
     * @Route("/cabinet/banners", name="admin_banners")
     */
    public function banners(MainBannersRepository $banners)
    {

      $banners_data = $banners->get_banners();
      // dd($banners_data);

        return $this->render('admin/banners/banners.twig', [
            'banners_data' => $banners_data,
        ]);
    }


    /**
     * @Route("/cabinet/ad", name="admin_ad")
     */
    public function ad(MainAdRepository $ads)
    {

      $ads_data = $ads->get_ads();
      // dd($banners_data);\

        return $this->render('admin/ad/ad.twig', [
            'ads_data' => $ads_data,
        ]);
    }


}
