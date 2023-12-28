<?php
require_once('config.php');

function getorders(){



$lastorder = $_GET['lastorderid'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$_ENV["STORE"].'/admin/api/2023-10/orders.json?limit=3&since_id='.$lastorder,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
      'X-Shopify-Access-Token: '.$_ENV["TOKEN"]
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}
$order_since = getorders();
echo $order_since;
?>