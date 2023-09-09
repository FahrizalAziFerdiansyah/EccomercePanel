<?php

/**
 * Created by PhpStorm.
 * User: Diandraa
 * Date: 2019-03-12
 * Time: 1:27 AM
 */

namespace App\Traits;


trait OngkirTrait
{
    public function rajaOngkir($param, $method = 'GET', $data)
    {
        $curl = curl_init();

        $arr = array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/" . $param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "key: e63e39232ce5884798e9e5f87929908c"
            ),
        );
        if ($method == 'POST') {
            array_push($arr[CURLOPT_HTTPHEADER], "content-type: application/x-www-form-urlencoded");
            $arr[CURLOPT_POSTFIELDS] = $data;
        }

        // dd($arr);
        curl_setopt_array($curl, $arr);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response([
                'success'   => false,
                'errors' => ['error' => $err]
            ], 404);
        } else {
            return json_decode($response);
        }
    }
}
