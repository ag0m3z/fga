<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 15/06/2017
 * Time: 10:36 PM
 */

header("Content-type: application/json");

    $curl_post_data = array(
        "SysKey"=>"adasdsd",
        "id"=>'1221',
        "referencia"=>"5555555530",
        "producto"=>"MOV010",
        "bolsaID"=>1
    );

    $curl = curl_init("http://pvt.bareylev.com/taecel/webapis/RequestTXN/");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    $curl_response = curl_exec($curl);

    $err = curl_error($curl);


    if ($err) {
        echo "cURL Error #:" . $err;

    } else {

        //echo $curl_response;

        $result =  json_decode( $curl_response);

        echo json_encode(array(
            'success'=>$result->{'success'},
            'error'=>$result->{'error'},
            'message'=>$result->{'message'},
            'data'=>$result->{'data'}
        ));

    }

    curl_close($curl);
