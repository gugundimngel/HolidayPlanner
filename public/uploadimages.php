<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://v4-api.grnconnect.com/api/v3/hotels/1848614/images',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'api-key: 8f03b8b760cdec2fca9464b2cd916e78',
    'Content-Type: application/json',
    'Accept: application/json',
    'Accept-Encoding: application/gzip'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;


echo '<pre>'; print_r(json_decode($response));