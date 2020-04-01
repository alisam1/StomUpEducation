<?php
use App\Kernel;
// use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/config/bootstrap.php';
function dd($var){
    dump($var);die();
}

//Функция для преобразования любого написания - в написание с заглавной строки
if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - Make a string's first character uppercase
     * @param string $str - The input string.
     * @param string $encoding - string $encoding [optional] &mbstring.encoding.parameter; default UTF-8
     * @return string str with first alphabetic character converted to uppercase.
     */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtolower($str,$encoding);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
               mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}

// функция для сортировки по убыванию многомерного массива, сортировка по определенному ключу
function cmp_function($a, $b){
return ($a['actual_events'] < $b['actual_events']);
  }

// if($_SERVER['REMOTE_ADDR'] == '79.134.197.134' || $_SERVER['REMOTE_ADDR'] == '172.23.0.1' || $_SERVER['REMOTE_ADDR'] == '172.18.0.1'){
//Глобальный ip
$GLOBALS['socket_ip'] = '192.168.1.67';

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'])) {
    (new Dotenv())->load(__DIR__.'/../.env');
}
// $_SERVER['APP_DEBUG'] = 0;
// if ($_SERVER['APP_DEBUG'] ?? ('prod' !== ($_SERVER['APP_ENV'] ?? 'dev'))) {
//     umask(0000);
//
//     Debug::enable();
// }

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

// } else {
//   echo "Сайт находится в разработке";
//   echo $_SERVER['REMOTE_ADDR'];
// }
