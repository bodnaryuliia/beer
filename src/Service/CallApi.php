<?php
/**
 * Created by PhpStorm.
 * User: Юля
 * Date: 20.10.2018
 * Time: 20:41
 */

namespace App\Service;


class CallApi
{
    public function getDataFromApi($url)
    {
        $curl = curl_init();

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }

}