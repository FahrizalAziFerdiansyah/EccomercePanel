<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OngkirController extends Controller
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
            return json_decode($response)->rajaongkir;
        }
    }
    public function city(Request $request)
    {
        $param = 'city?province=' . $request->province_id;
        return $this->rajaOngkir($param, null, null);
    }
    public function province()
    {
        $param = 'province';
        return $this->rajaOngkir($param, null, null);
    }
    public function cost(Request $request)
    {
        $data = collect($request->all());
        $str = '';
        $i = 1;
        foreach ($data as $key => $value) {
            $str .= $key . '=' . $value;
            if ($i !== count($data)) {
                $str .= '&';
            }
            $i++;
        }
        $param = 'cost';
        $resp = $this->rajaOngkir($param, 'POST', $str);

        return response([
            'success' => true,
            'cost' => $resp->results[0]->costs[0]->cost[0]->value
        ], 201);
    }
}
