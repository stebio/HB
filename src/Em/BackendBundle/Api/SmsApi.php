<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 27/04/16
 * Time: 11:44
 */

namespace Em\BackendBundle\Api;

use Em\BackendBundle\Mesclass\Unicode;

class SmsApi
{

    public function isSmsapi($to, $message )
    {

        $username = 'emitic';
        $password = '007Jockers@';//'08710358'
        $sender   = 'AFRIKHOTEL';
        $type     = 'text';
        $message = urlencode($message); //$this->converUnicode($message);

        $datetime = urlencode(date('Y-m-d H:i'));
        //$destinataire = ;

        /*http://africasmshub.mondialsms.net/api/api_http.php?username=emitic&password=007Jockers%40&sender=AFRIKHOTEL&to=22508710358&text=Hello%20world
&type=text&datetime=2017-08-12%2010%3A02%3A42*/

        $smsapi = 'http://africasmshub.mondialsms.net/api/api_http.php?username='.$username.'&password='.$password.'&sender='.$sender.'&to=225'.$to
            .'&text='.$message.'&type='.$type.'&datetime='.$datetime;

        return file_get_contents($smsapi);
    }

    public function converUnicode($text){

       $convert = new Unicode();

        return $text = $convert->str_to_unicode($text, 'UTF-8');
    }

}