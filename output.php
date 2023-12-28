<?php
function getPost() {
$content1 = $_POST['content1'];
$content2 = $_POST['content2'];
$content3 = $_POST['content3'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blocks = array();
    $blockarray=array();
    $titlecount=1;
    $imagecount=1;
        foreach ($_POST as $key => $value) {

           if(str_contains($key, 'title')   ) { 
  
           $blockarray["block".$titlecount]['title']=$value;

             $titlecount++;
           }
           if(str_contains($key, 'image')   ) { 
  
            $blockarray["block".$imagecount]['url']=$value;

              $imagecount++;
            }
           
     
        }
  //  print_r($blocks);


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





// function createJsonFile(){
// $title1=$_POST['title1'];
// $title2=$_POST['title2'];
// $title3=$_POST['title3'];
// $imageurl1 = $_POST['image1'] ;
// $imageurl2 = $_POST['image2'] ;
// $imageurl3 = $_POST['image3'] ;


// $data1 = array(
//     'title'=>$title1,
//     'url' => $imageurl1,

// );
// $data2 = array(
//     'title'=>$title2,
//     'url' => $imageurl2,
  
// );
// $data3 = array(
//     'title'=>$title3,
//     'url' => $imageurl3,

// );



// // Convert PHP array to JSON string
// $jsonString = json_encode($mainarray, JSON_PRETTY_PRINT);

// // Specify the file path where you want to save the JSON file
// $filePath = 'output.json';

// // Write the JSON string to the file
// file_put_contents($filePath, $jsonString);


// echo $jsonString;
// }

// function readOutputfile(){
// $jsonFilePath = './output.json';

// // Read the JSON file content
// $jsonData = file_get_contents($jsonFilePath);

// // Decode the JSON data
// $decodedData = json_decode($jsonData, true);

// // Check if decoding was successful
// if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
//     die('Error decoding JSON: ' . json_last_error_msg());
// }


// return $decodedData;

// }
// if(isset($_POST['send']))

// createJsonFile();
?>
