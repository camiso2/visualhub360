<?php
namespace App\Custom;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;



class GeneratedCookies{

    public  static function setCookieOrder()
    {
        $ordersCookie = Cookie::get('orders');
         // Verificar si la cookie está vacía o no existe
         if (empty($ordersCookie)||is_null($ordersCookie)) {
            // Si la cookie está vacía o no existe, establecer una nueva cookie 'orders' con un valor único
            Cookie::queue('orders', Str::uuid(), 1440, '/', null, false, false);
        }
    }

    public static function getCookieOrder()
    {
        return Cookie::get('orders');
    }




}
