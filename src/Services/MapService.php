<?php

namespace App\Services;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use App\Repository\UsersRepository;

class MapService
{

//Тут используется API yandex-maps
public function get_cord_by_yandex($str){

  //Кодируем строку адресса
  $str = urlencode($str);
  // делаем запрос по апи яндекса
  $data = file_get_contents('https://geocode-maps.yandex.ru/1.x/?apikey=a6df09da-318c-444e-9b95-37153ff678c9&format=json&geocode='.$str.'');

  // Разбираем данные
  $jsonData = json_decode($data);



  if( property_exists($jsonData, 'response' ) ){

    $position = $jsonData->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;

    $pos = explode(' ',$position);


    if(count($pos)  > 0){

      $pos = $pos[1].', '.$pos[0];
      //Возвращаем координаты
      return $pos;
    } else {
      return 'Fail';
    }



  } else {
    return 'Fail';
  }

}

//Тут используется API спутника, т.к. оно бесплатное :)
//Если перестанет работать, нужно будет разобраться с API Яндекса или гугла
//!!! Внимание !!! Это очень нестабильный сервис - он зачастую нам возвращает только начало улицы. Используем только в крайнем случае
//Резерв Геокодер
public function get_cord_by_sputnik($str){

  $str = urlencode($str);
  $data = file_get_contents('http://search.maps.sputnik.ru/search/addr?q='.$str.'');


  $jsonData = json_decode($data);

  if( property_exists($jsonData, 'meta' ) ){
    $lat = $jsonData->result->viewport->TopLat;
    $long = $jsonData->result->viewport->TopLon;

    $cord = $lat.', '.$long.'';

    return $cord;
  }
  else {
    return 'Fail';
  }


}


}

 ?>
