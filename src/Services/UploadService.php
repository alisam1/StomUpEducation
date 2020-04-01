<?php

namespace App\Services;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use App\Repository\UsersRepository;
use Overvoidjs\imgun;

class UploadService
{


  //Создаем файл
  //Для использования сервиса передаем в качестве параметра
  //$image - $_FILE['post_name']
  //$dir_name - имя существующей папки в каталоге uploads/
  public function make_image($image,$dir_name){

    // TODO: Добавить сюда функционал удаления предидушего аватара, что бы не засорять диск

    // Проверяем размер файла и если он превышает заданный размер
    // завершаем выполнение скрипта и выводим ошибку
    if ($image['size'] > 2097152) {
      return 'FailSize';
    }

    // Достаем формат изображения
      $imageFormat = explode('.', $image['name']);
      $imageFormat = $imageFormat[1];


      // Генерируем новое имя для изображения. Можно сохранить и со старым
      // но этого не рекомендуется делать
      $new_img_name = hash('crc32',rand());

      $imageFullName = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $dir_name . '/' . $new_img_name . '.' . $imageFormat;

      // Сохраняем тип изображения в переменную
      $imageType = $image['type'];

      // Сверяем доступные форматы изображений, если изображение соответствует,
      // копируем изображение в папку images
      if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
        $stack_img_path = '/uploads/'.$dir_name.'/'.$new_img_name.'.'.$imageFormat;
        if (move_uploaded_file($image['tmp_name'],$imageFullName)) {
          //Возвращаем полный путь до созданного файла
           // $stack_img_path;

           //Набор констант для обрезания
           $min_w = 300;
           $min_h = 300;
           $quality = 70;

           // создаем миниатюру
           $imgun = new imgun($imageFullName);

           $img_info = $imgun->get_img_info();

           if($img_info['width'] > $min_w){
             $imgun->resizeImage($min_w, $min_h, 'auto');
             $imgun->saveImage(''.$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$dir_name.'/min/'.$new_img_name.'.'.$imageFormat.'', $quality);
           }


           return $stack_img_path;
        } else {
          return 'Fail';
        }
      }

  }


  //создаем много файлов
  public function make_many_image($image,$dir_name){

    // TODO: Добавить сюда функционал удаления предидушего аватара, что бы не засорять диск

    //Создаем безимянное хранилище
    $many_files = [];
    for ($i=0; $i < count($image['name']); $i++) {


    // Проверяем размер файла и если он превышает заданный размер
    // завершаем выполнение скрипта и выводим ошибку
    if ($image['size'][$i] > 2097152) {
      return 'FailSize';
    }

    // Достаем формат изображения
      $imageFormat = explode('.', $image['name'][$i]);
      $imageFormat = $imageFormat[1];


      // Генерируем новое имя для изображения. Можно сохранить и со старым
      // но этого не рекомендуется делать
      $new_img_name = hash('crc32',rand());

      $imageFullName = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $dir_name . '/' . $new_img_name . '.' . $imageFormat;

      // Сохраняем тип изображения в переменную
      $imageType = $image['type'][$i];

      // Сверяем доступные форматы изображений, если изображение соответствует,
      // копируем изображение в папку images
      if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
        $stack_img_path = '/uploads/'.$dir_name.'/'.$new_img_name.'.'.$imageFormat;
        if (move_uploaded_file($image['tmp_name'][$i],$imageFullName)) {
          //Возвращаем полный путь до созданного файла

          //Набор констант для обрезания
          $min_w = 300;
          $min_h = 300;
          $quality = 70;

          // создаем миниатюру
          $imgun = new imgun($imageFullName);

          $img_info = $imgun->get_img_info();

          if($img_info['width'] > $min_w){
            $imgun->resizeImage($min_w, $min_h, 'auto');
            $imgun->saveImage(''.$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$dir_name.'/min/'.$new_img_name.'.'.$imageFormat.'', $quality);
          }

          $many_files[] = $stack_img_path;
        } else {
          return 'Fail';
        }
      }

        }

        if(count($many_files) > 0){
          return $many_files;
        } else {
          return 'Fail';
        }

  }



  public function upload_api_files($file,$dir_name){

    // dd('hex');

    if($file['size'] > 10485760){
      return 'FailSize';
    }

    // dd($file);

    // Достаем формат
      // $fileFormat = explode('.', $file['name']);
      $fileFormat = 'xml';

      // dd($fileFormat);

      // Генерируем новое имя для файла.
      $new_file_name = hash('crc32',rand());

      $fileFullName = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $dir_name . '/' . $new_file_name . '.' . $fileFormat;

      // Сохраняем тип изображения в переменную
      $fileType = $file['type'];

      if($fileType == 'text/xml'){

        $stack_file_path = '/uploads/'.$dir_name.'/'.$new_file_name.'.'.$fileFormat;
        if (move_uploaded_file($file['tmp_name'],$fileFullName)) {
          //Возвращаем полный путь до созданного файла
          return $stack_file_path;

      } else {
        return 'Fail';
      }




  }
  }




}

 ?>
