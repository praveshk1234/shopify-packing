<?php
require_once('./config.php');

function get_customer_orders($id){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$_ENV["STORE"].'/admin/api/2023-10/customers/'.$id.'/orders.json',
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

$customer = curl_exec($curl);

curl_close($curl);
return $customer;
}

function get_customer($id){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$_ENV["STORE"]'./admin/api/2023-10/customers/'.$id.'.json',
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

$customer = curl_exec($curl);

curl_close($curl);
return $customer;
}
?>
