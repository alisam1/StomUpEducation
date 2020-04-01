<?php
/**
 * Created by PhpStorm.
 * User: maslitto
 * Date: 14.03.18
 * Time: 17:06
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class AppExtension extends AbstractExtension {

  public function getFilters()
    {
        return [
          new TwigFilter('json_decode', [$this, 'jsonDecode']),
          new TwigFilter('str30', [$this, 'str30']),
          new TwigFilter('str225', [$this, 'str225']),
          new TwigFilter('totimejs', [$this, 'totimejs']),
          new TwigFilter('short_name', [$this, 'short_name']),
          new TwigFilter('split_date_and_time', [$this, 'split_date_and_time']),
          new TwigFilter('delete_seconds_from_time', [$this, 'delete_seconds_from_time']),
          new TwigFilter('downcounter', [$this, 'downcounter']),
          new TwigFilter('beautifultext', [$this, 'beautifultext']),
          new TwigFilter('onlyone', [$this, 'onlyone']),
          new TwigFilter('minimg', [$this, 'minimg']),
        ];
    }

    //Функция вывода только первого значения в списке с ,
    public function onlyone($str){
      if(strpos($str,',')){
        $str = explode(',',$str);

        return $str[0];
      } else {
        return $str;
      }
    }

    //Возвращаем путь к картинке min
    public function minimg($url){
      $arr = explode('/',$url);
      $new_str = '/';
      for ($i=1; $i < count($arr); $i++) {
        $new_str .= $arr[$i] . '/';
        if($i == count($arr)-2 ){
          $new_str .= 'min/';
        }
      }

      $new_str = substr($new_str,0,-1);

      return $new_str;
    }


    //Функция подсчета обратного отсчета до числа
    public function downcounter($date){
	    $check_time = strtotime($date) - time();
	    if($check_time <= 0){
	        return false;
	    }

	    $days = floor($check_time/86400);
	    $hours = floor(($check_time%86400)/3600);
	    $minutes = floor(($check_time%3600)/60);
	    $seconds = $check_time%60;

	    $str = '';
	    if($days > 0){
        $str .= $days.'д:';
      }
	    if($hours > 0){
         $str .= $hours.'ч:';
         }
	    if($minutes > 0){
        $str .= $minutes.'м';
        }
	    // if($seconds > 0) $str .= declension($seconds,array('секунда','секунды','секунд'));

	    return $str;
	}


  //Применение функции преобразования любой строки к стилю с Заглавной буквы
  public function beautifultext($str){
    return mb_ucfirst($str);
  }


    //Расширяет возможности TWIG в JSONdecode
    public function jsonDecode($json)
    {
        return json_decode($json);
    }

    //Делаем из полного имени, сокращенное
    //Например Фролова Вероника Васильевна -> Фролова В.В.
    public function short_name($name)
    {

      $name = trim($name);
      $arr_name = explode(' ', $name);

      if( count($arr_name) > 2 ){

      $first_name = mb_substr($arr_name[1], 0, 1,'UTF-8') . '. ';
      $last_name = mb_substr($arr_name[2], 0, 1,'UTF-8') . '. ';

      $make_short_name = $arr_name[0].' '.$first_name.$last_name;

        return $make_short_name;

        }
        else {
          return $name;
        }
    }

    //Удаляет секунды из формата времени 00:00:00 -> 00:00
    public function delete_seconds_from_time($time){
        return substr($time,0,-3);
    }

    //Разрывает строку даты и времени. 2019-10-12 22:00:00 -> ['2019-10-12','22:00:00']
    public function split_date_and_time($datetime){
      $datetime = explode(' ', $datetime);

      return $datetime;
    }

    //Сокращает максимальную длину текста до 30 символов
    public function str30($string)
    {
      //Если длина больше 30
      if(strlen($string) >= 30 ){
        //Убираем теги
        $string = strip_tags($string);
        //Обрезаем строку
        $string = mb_substr($string, 0, 30,'UTF-8');
        //Добавляем '...'
        $string = $string.'...';

        }

        return $string;
    }
    //Сокращает длину текста до 225 символов
    public function str225($string)
    {
      //Если длина больше 225 символов
      if(strlen($string) >= 225 ){
        //Убираем теги
        $string = strip_tags($string);
        //Обрезаем строку
        $string = mb_substr($string, 0, 225,'UTF-8');
        //Добавляем '...'
        $string = $string.'...';

        }

        return $string;
    }

    //Преобразует формат времени в Т
    public function totimejs($date)
    {
      //В пойманном времини заменяем пробел на T

      $date = str_replace(' ','T',$date);
      return $date;
    }
}
