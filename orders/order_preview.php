<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('order.php');

?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>NineTwoFive Order Preview</title>

</head>
<body>
<?php 
$orderarray = json_decode($single_order,true);
$order = $orderarray['order'];
$order_date = date( 'Y m d',strtotime($order['created_at']) ) ;

$json = file_get_contents('../output.json',true);
$jsonobj = json_decode($json,true);


$customerid = $order['customer']['id'];
$customer_array = get_customer($customerid);

$customer = $customer_array['customer'];

$customer_order_count = $customer['orders_count'];

//echo "order count item".$customer['orders_count'];
// item condition 

//echo "<pre>";
$getblocks = $jsonobj['slips']['blocks'];
$getcontents=$jsonobj['slips']['contents'];
$blockcount = count($getblocks);


$item1 = $getblocks['block1']['title'];
$item2 = $getblocks['block2']['title'];
//$item3 = $getblocks['block3']['title'];

$itemtitle = array_column($getblocks, 'title');

$is_item1 = false;
$is_item2 = false;
$is_item3 = false;

  $is_condition1=false;
$is_condition2=false;
$is_condition3=false;

$price = 20;
$country_code = 'IN';
$order_price = $order['total_price'];

$customer_country = $order['shipping_address']['country_code'];


// // show when order is the 2nd order above €20
 if($order_price > $price && $customer_country == $country_code && $customer_order_count == 2)
 $is_condition2 = true;

 else if($order_price > $price && $customer_order_count == 2)
 $is_condition1 = true;

// 2nd order above €20 when country = Netherlands



// //Customer 3rd order above €20 and country = Netherlands.
else if($order_price > $price && $customer_country == $country_code && $customer_order_count == 3)
 $is_condition3 = true;

else{
  $is_condition1=false;
$is_condition2=false;
$is_condition3=false;

}

?>
<button type="text" id="printpage">Print</button>
<a href='./../index.php'>Upload Images</a>
<div id="js-inputimage">
  <?php
  for ($x = 1; $x <= $blockcount; $x++) {
     $xy = "block".$x."";
echo "<input type='hidden' id='imageblock-".$x."' data-title='".$getblocks[$xy]['title']."' value='".$getblocks[$xy]['url']."'>"; 
}
?>
</div>
<div class="printpreview">
<link rel="stylesheet" href="https://cdn.shopify.com/s/files/1/0197/0742/8926/files/libre-barcode-39-inline.css?v=1675429300" type="text/css" media="all">
<div class="wrapper">
  <div class="header">
    <div class="order-title">
      <p class="text-align-left">
        <?php
        echo "Order ".$order['name'];
        ?>
      </p>
      <p class="text-align-left" style="margin: 0 0 10px;">
      <?php   echo $order_date; ?> 
      </p>
      <p class="order_bar_code"> <?php echo "*NTF".$order['order_number']."*"; ?></p>
    </div>


  </div>
<div class="shop_name_header"  style="margin: 10px 0 0;">
    <div class="shop-title">
      <p class="to-uppercase" style="margin: 0;">
NINETWOFIVE
      </p>
    </div>   
</div> 
  <div class="customer-addresses">
    <div class="shipping-address">
      <p class="subtitle-bold to-uppercase">
    <!--   {% if delivery_method.instructions != blank %}
          Delivery to
        {% else %}
          Ship to
        {% endif %} -->
             Ship to
      </p>
      <p class="address-detail">
      <?php
   
     if($order['shipping_address']){
      echo "<br>".$order['shipping_address']['name'];
      
        if($order['shipping_address']['company'])
        echo "<br>".$order['shipping_address']['company'];
       echo "<br>".$order['shipping_address']['address1'];
       if($order['shipping_address']['address2'])
          echo "<br>".$order['shipping_address']['address2'];
          
        if($order['shipping_address']['province_code'])
          echo "<br>".$order['shipping_address']['province_code'];
          
            if($order['shipping_address']['country'])
          echo "<br>".$order['shipping_address']['country'];
          
           if($order['shipping_address']['phone'])
          echo "<br>".$order['shipping_address']['phone'];
          
          }
          else{
          echo "No shipping address";
          }
      ?>
 
      </p>
    </div>
    <div class="billing-address">
      <p class="subtitle-bold to-uppercase">
        Bill to
      </p>
      <p class="address-detail">
      <?php
         if($order['billing_address']){
      echo "<br>".$order['billing_address']['name'];
      
        if($order['billing_address']['company'])
        echo "<br>".$order['billing_address']['company'];
       echo "<br>".$order['billing_address']['address1'];
       if($order['billing_address']['address2'])
          echo "<br>".$order['billing_address']['address2'];
          
        if($order['billing_address']['province_code'])
          echo "<br>".$order['billing_address']['province_code'];
          
            if($order['billing_address']['country'])
          echo "<br>".$order['billing_address']['country'];
          
           if($order['billing_address']['phone'])
          echo "<br>".$order['billing_address']['phone'];
          
          }
          else{
          echo "No billing address";
          }
      ?>
      

      </p>
    </div>
  </div>
  <hr>
  <div class="order-container">
    <div class="order-container-header">
      <div class="order-container-header-left-content">
        <p class="subtitle-bold to-uppercase">
          Quantity
        </p>
      </div>      
      <div class="order-container-header-right-content">
        <p class="subtitle-bold to-uppercase">
          Items
        </p>
      </div>

    </div>


<?php
$curImageArray= array();
foreach($order['line_items'] as $key => $line_item){
//condition for lineitem
//array_push($curImageArray,$line_item['title'] ) ;

 foreach($itemtitle as $key => $value){
    if(str_contains($line_item['title'],$value)){
    array_push($curImageArray,$value);
    }
   
}






$linequantity = $line_item['quantity'];

$line_image = get_product($line_item['product_id']);
//$line_array_image= $line_image['product']['image']['src'];

$current_item = json_decode($line_image,true);
$line_item_image = $current_item['product']['image']['src'];

//print_r($current_item);
//$current_image = $line_image['image']['src'];

foreach(range(1,$linequantity) as $i){
echo "
     <div class='flex-line-item'>
        <div class='flex-line-item-quantity'>
          <p class='text-align-left'>
            1 of 1
          </p>
        </div>        
        <div class='flex-line-item-img'>
     
        
            <div class='aspect-ratio aspect-ratio-square' style='width: 50px; height: 50px;'>
                 <img src=".$line_item_image." width='50' height='50' />
          
            </div>
      
        </div>

        <div class='flex-line-item-description'>
          <p>
            <span class='line-item-description-line'>
              ".$line_item['title']."
            </span>
          ".($line_item['variant_title'] ? " <span class='line-item-description-line'>".$line_item['variant_title']." </span>":"")."
       
              ".($line_item['sku'] ? " <span class='line-item-description-line'>".$line_item['sku']." </span>":"")."";
      
      
      
foreach($line_item['properties'] as $key => $property){
 $property_first_char = $property;
 $property_first_char = $property['name'][0];
 if(($property['value'] != "") and ($property_first_char != '_')){
 echo " <div class='product-option'> <span>".$property['name'].":</span>
                              <span> ".$property['value']."</span></div>
                              ";
  
 }

}
   /*          {%- for property in line_item.properties -%}
                          {%- assign property_first_char = property.first | slice: 0 -%}
                          {%- if property.last != blank and property_first_char != '_' -%}
                            <div class='product-option'>
                              <span>{{ property.first }}:</span>
                              <span>
                                {%- if property.last contains '/uploads/' -%}
                                  <a href='{{ property.last }}' class='link' target='_blank'>
                                    {{ property.last | split: '/' | last }}
                                  </a>
                                {%- else -%}
                                  {{ property.last }}
                                {%- endif -%}
                              </span>
                            </div>
                          {%- endif -%}
                        {%- endfor -%}*/

       echo "   </p>
        </div>

      </div>
";
}
}

?>

<!--

  {% unless includes_all_line_items_in_order %}
    <hr class="subdued-separator">
    <p class="missing-line-items-text ">
      There are other items from your order not included in this shipment.
    </p>
  {% endunless %}
  -->
  <hr>

  <?php if($order['note']){
  
  echo " <div class='notes'><p class='subtitle-bold to-uppercase'>
        Notes
      </p>
      <p class='notes-details'>".$order['note']."
      </p>
    </div>";
    }
  ?>
 
    
<!--
  {% if delivery_method.instructions != blank %}
    <div class="notes">
      <p class="subtitle-bold to-uppercase">
        Delivery instructions
      </p>
      <p class="notes-details">
        {{ delivery_method.instructions }}
      </p>
    </div>
  {% endif %}
  -->
  <div class="footer">
    <p>
      Thank you for shopping with us!
    </p>
    <p>
      <strong>
     NineTwoFive
      </strong>
      <br>
Het Gangboord 19, 9206 BJ Drachten, Netherlands
      <br>
   support@ninetwofive.com
      <br>
     ninetwofive.com
    </p>
  </div>
</div>


</div>
</div>
  <?php


for ($y = 1; $y <= 3; $y++) {
if(($y==1 and $is_condition1) or ($y==2 and $is_condition2) or ($y==3 and $is_condition3 )){
     $yx = "content".$y."";
echo "<div class='row avoid fullpage ' >
<div class='boxitem mb-4 px-0' style='text-align: center; display: flex; justify-content: center; align-items: center; flex-direction: column-reverse;'>
        <label for='richtext".$y."'>".$getcontents[$yx]['title'].":</label>
<div class='editor contentbox".$y."' style='text-align:center;'>
".$getcontents[$yx]['richtext']."
</div></div></div>";
}
 }

//    $y1 = "content1";

// echo "<div class='row avoid fullpage ".($is_condition1?'':'hidden')."' >
// <div class='boxitem mb-4 px-0' style='text-align: center; display: flex; justify-content: center; align-items: center; flex-direction: column-reverse;'>
//         <label for='richtext1'>".$jsonobj->slips->$y1->title.":</label>
// <div class='editor contentbox1' style='text-align:center;'>
// ".$jsonobj->slips->$y1->richtext."
// </div></div></div>";

//    $y2 = "content2";
// echo "<div class='row avoid fullpage ".($is_condition2 ?'':'hidden')."' >
// <div class='boxitem mb-4 px-0' style='text-align: center; display: flex; justify-content: center; align-items: center; flex-direction: column-reverse;'>
//         <label for='richtext2'>".$jsonobj->slips->$y2->title.":</label>
// <div class='editor contentbox2' style='text-align:center;'>
// ".$jsonobj->slips->$y2->richtext."
// </div></div></div>";

//    $y3 = "content3";
// echo "<div class='row avoid fullpage ".($is_condition3?'':'hidden')." ' >
// <div class='boxitem mb-4 px-0' style='text-align: center; display: flex; justify-content: center; align-items: center; flex-direction: column-reverse;'>
//         <label for='richtext3'>".$jsonobj->slips->$y3->title.":</label>
// <div class='editor contentbox3' style='text-align:center;'>
// ".$jsonobj->slips->$y3->richtext."
// </div></div></div>";






?>



<style type="text/css">
  body {
    font-size: 15px;
  }

  * {
    box-sizing: border-box;
    margin:0;
  }

  .wrapper {
    width: 831px;
    margin: auto;
    padding: 4em;
    font-family: "Noto Sans", sans-serif;
    font-weight: 250;
  }

  .header {
    width: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    flex-direction: row;
    align-items: top;
  }

  .header p {
    margin: 0;
  }

  .shop-title {
    -webkit-box-flex: 6;
    -webkit-flex: 6;
    flex: 6;
    font-size: 1.9em;
  }

  .order-title {
    -webkit-box-flex: 4;
    -webkit-flex: 4;
    flex: 4;
  }

  .customer-addresses {
    width: 100%;
    display: inline-block;
    margin: 2em 0;
  }

  .address-detail {
    margin: 0.7em 0 0;
    line-height: 1.5;
  }

  .subtitle-bold {
    font-weight: bold;
    margin: 0;
    font-size: 0.85em;
  }

.text-align-right {
    text-align: right;
  }

  .shipping-address {
    float: left;
    min-width: 18em;
    max-width: 50%;
  }

  .billing-address {
    padding-left: 20em;
    min-width: 18em;
  }

  .order-container {
    padding: 0 0.7em;
  }

  .order-container-header {
    display: inline-block;
    width: 100%;
    margin-top: 1.4em;
  }

  .order-container-header-left-content {
    float: left;
    width:20%;
  }

  .order-container-header-right-content {
    float: right;
    width:80%;
  }
  .hidden{
    display: none;
  }

  .flex-line-item {
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    flex-direction: row;
    align-items: center;
    margin: 1.4em 0;
    page-break-inside: avoid;
  }

  .flex-line-item-img {
    margin-right: 1.4em;
    min-width: {{ desired_image_size }}px;
  }

  .flex-line-item-description {
    -webkit-box-flex: 7;
    -webkit-flex: 7;
    flex: 7;
  }

  .line-item-description-line {
    display: block;
  }

  .flex-line-item-description p {
    margin: 0;
    line-height: 1.5;
  }

  .flex-line-item-quantity {
    -webkit-box-flex:  1 1 20%;
    -webkit-flex:  1 1 20%;
    flex: 1 1 20%;
    width: 20%;
  }

  .subdued-separator {
    height: 0.07em;
    border: none;
    color: lightgray;
    background-color: lightgray;
    margin: 0;
  }

  .missing-line-items-text {
    margin: 1.4em 0;
    padding: 0 0.7em;
  }

  .notes {
    margin-top: 2em;
  }

  .notes p {
    margin-bottom: 0;
  }

  .notes .notes-details {
    margin-top: 0.7em;
  }

  .footer {
    margin-top: 2em;
    text-align: center;
    line-height: 1.5;
  }

  .footer p {
    margin: 0;
    margin-bottom: 1.4em;
  }

  hr {
    height: 0.14em;
    border: none;
    color: black;
    background-color: black;
    margin: 0;
  }

  .aspect-ratio {
    position: relative;
    display: block;
    background: #fafbfc;
    padding: 0;
  }

  .aspect-ratio::before {
    z-index: 1;
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 1px solid rgba(195,207,216,0.3);
  }

  .aspect-ratio--square {
    width: 100%;
    padding-bottom: 100%;
  }

  .aspect-ratio__content {
    position: absolute;
    max-width: 100%;
    max-height: 100%;
    display: block;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
  }
 .order_bar_code { 
   font-family: 'Libre Barcode 39 Text', cursive;
   font-size: 60px;
    display: inline-block;
    width:100%; 
   height:95px;
   overflow:hidden;
 }
  .shop_name_header {
    display: inline-block;
    width:100%;
  }
</style>

<script>
function createPDF() {


 const is_item1 = <?php echo json_encode($is_item1); ?>;
 const is_item2 = <?php echo json_encode($is_item2); ?>;
  const is_item3 = <?php echo json_encode($is_item3); ?>;


 const is_content1 = <?php echo json_encode($is_condition1);?>;
const is_content2 = <?php echo json_encode($is_condition2);?>;
const is_content3 = <?php echo json_encode($is_condition3);?>;


 function firstImage(element){
return new Promise((resolve)=>{
var opt = {

  html2canvas:  { scale: 2 }

};
    html2pdf().from(element).set(opt).toCanvas().toImg().get('canvas').then(
function(canvas){


  resolve(canvas.toDataURL('image/jpeg')) ;

}
)
})


}

async function item() {
  let argarr = [];
            try {
                // Capture content1 as an image

               if(is_content1){
                const content1Image = await firstImage(document.querySelector('.contentbox1')); 
                argarr.push(conten