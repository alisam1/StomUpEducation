<?php

namespace App\Services;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use App\Repository\UsersRepository;

class PhoneService
{

  //Функция отчистки телефона, принимает строку
  public function clear_phone($phone){

    //Перечислим символы которые нам нужно удалить из строки
    $symbols_for_delate = ['+','-','(',')', ' '];
    //Отчистим строку от символов
    $phone = str_replace($symbols_for_delate, '', $phone);

    //Стандартизируем номер телефона, если в начале 8, то заменим ее на 7
    if( $phone[0] == '8' ){
      $phone[0] = '7';
    }

    //Вернем очищенный телефон
    return $phone;

  }

  //Делаем телефон опять форматированным по стандарту +7 (999) 999-99-99
  public function nice_phone($phone){

    $phone = substr_replace($phone, "+", 0, 0);
    $phone = substr_replace($phone, " (", 2, 0);
    $phone = substr_replace($phone, ") ", 7, 0);
    $phone = substr_replace($phone, "-", 12, 0);
    $phone = substr_replace($phone, "-", 15, 0);

    return $phone;

  }


}

 ?>
