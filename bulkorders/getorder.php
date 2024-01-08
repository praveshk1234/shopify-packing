<?php

require_once('../config.php');



function get_order($order_id){


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://".$_ENV["STORE"]."/admin/api/2023-10/orders/".$order_id.".json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-Shopify-Access-Token:'.$_ENV["TOKEN"]
  ),
));

$get_order = curl_exec($curl);

curl_close($curl);

return $get_order;
}
function get_product($product_id){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$_ENV["STORE"].'/admin/api/2023-10/products/'.$product_id.'.json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
   'X-Shopify-Access-Token:'.$_ENV["TOKEN"]
  ),
));

$curr_product = curl_exec($curl);

curl_close($curl);
return $curr_product;

}
 

function get_customer($customer_id){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$_ENV["STORE"].'/admin/api/2023-10/customers/'.$customer_id.'.json',
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
return json_decode($customer,true);

}


?>
