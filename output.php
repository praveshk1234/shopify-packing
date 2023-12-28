<?php
function getPost() {
$content1 = $_POST['content1'];
$content2 = $_POST['content2'];
$content3 = $_POST['content3'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $blockarray=array();
    $titlecount=1;
    $imagecount=1;
        foreach ($_POST as $key => $value) {

           if(str_contains($key, 'title')   ) { 
  
           $blockarray["block".$titlecount]['title']=$value;

             $titlecount++;
           }
           elseif(str_contains($key, 'image')   ) { 
  
            $blockarray["block".$imagecount]['url']=$value;

              $imagecount++;
            }
           
     
        }



$content1 = array(
    'title'=>'order is the 2nd order above €20',
    'richtext' => $content1,

);
$content2 = array(
    'title'=>'2nd order above €20 when country = Netherlands',
    'richtext' => $content2,

);
$content3 = array(
    'title'=>' 3rd order above €20 and country = Netherlands.',
    'richtext' => $content3,
   
);

$contents=array("content1" => $content1,"content2" => $content2,"content3" => $content3);
$mainarray = array("slips" => array("blocks"=> $blockarray,"contents" => $contents));
$jsonString = json_encode($mainarray, JSON_PRETTY_PRINT);

// Specify the file path where you want to save the JSON file
$filePath = 'output.json';

// Write the JSON string to the file
file_put_contents($filePath, $jsonString);
echo $jsonString;
    }
else {
    echo "No POST requests received.";
}


 
}
function readOutputfile(){
$jsonFilePath = './output.json';

// Read the JSON file content
$jsonData = file_get_contents($jsonFilePath);

// Decode the JSON data
$decodedData = json_decode($jsonData, true);

// Check if decoding was successful
if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON: ' . json_last_error_msg());
}
return $decodedData;
}
 if(isset($_POST['send']))
getPost();



?>
