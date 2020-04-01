<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class TestService
{


public function isTest($test){

  if($test == '76666666666'){

    return FALSE;
  } else {
    return TRUE;
  }

}


}

 ?>
