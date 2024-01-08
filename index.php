<!DOCTYPE html>
<html>
<head>
<?php
require_once('config.php');
require_once('output.php');
$json = file_get_contents('output.json',true);
$jsonobj = json_decode($json,true);
$blockcount= count($jsonobj['slips']['blocks']);

?>

<title>Packing Slip</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./css/style.css">


<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


</head>
<body>

         <?php
      //   $currentshop = $_GET['shop'];
      // if($currentshop == $_ENV['STORE']){
  
      
     ?>
<header>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="#">
        <img src="./images/Logo_white.webp" class="img-fluid" alt="Logo" />
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
      
<a class='nav-item nav-link active' href='#'>Home <span class='sr-only'></span></a>;
  
        </div>
      </div>
    </nav>
  </div>
</header>
<div class="upload-content-sec my-5">
    <div class="container ">
  <div class="row " id="imageblockbox">
  <form action="./upload.php" method="post" class="SlipForm" enctype="multipart/form-data">
  <input type="hidden" name="send"/>
  <h5 class="fw-bold mb-3">Upload How to Wear Image</h5>
  <div class="container">
  <div class="row">
  <table class="table table-bordered text-center">
  <thead>
    <tr>
      <th scope="col" width="10%">Index</th>
      <th scope="col" width="15%">Title</th>
      <th scope="col" width="30%">Preview url</th>      
      <th scope="col" width="45%">Preview Image</th>
    </tr>
  </thead>
  <tbody>
  <?php
$getblock = $jsonobj['slips']['blocks'];
$getcontents = $jsonobj['slips']['contents'];
for ($x = 1; $x <= $blockcount; $x++) {
  $xy = "block".$x."";
echo " <tr class='block".$x." blockcontent' data-index=".$x.">
   <th scope='row mb-3'>".$x."</th>
      <th class='title'>  <input type='text' class='imagetitle' name='title".$x."' value='".$getblock[$xy]['title']."' class='form-control'></th>
      <td>  <input type='url' class='imageurl' name='image".$x."' value='".$getblock[$xy]['url']."' class='form-control' required></td>
      <td><div class='col img-box'>
      <button onclick='removeRow(this)' class='close-btn'> &#215;</button>
<img src ='".$getblock[$xy]['url']."' width='100' height='100' id='imageblock' />
</div></td>
    </tr>";
  }
  ?>
  </tbody>
</table>
<button type="text" id="addblock" class="btn btn-primary">Add block</button>
  </div>
</div>
<h5 class="fw-bold my-3">Edit Thank you content</h5>
<div class="container richbox">
<?php
for ($y = 1; $y <= 3; $y++) {
     $yx = "content".$y."";
echo "<div class='row'>
<div class='boxitem mb-4 px-0'>
        <label for='richtext".$y."'>".$getcontents[$yx]['title'].":</label>
        <textarea name='content".$y."' style='display:none'></textarea>
<div class='editor contentbox".$y."'>
".$getcontents[$yx]['richtext']."
</div></div></div>";
}
?>
 <div class="row">
            <input type="submit" value="Submit" class="btn btn-primary submit-btn" name="submit">
        </div>
        </div>
</form>
<a href="orders/upload_pre.php?id=5873718067528" class="link-primary link-offset-2 print-preview-btn">Print Preview</a>
</div>
</div>
</div>
<!-- show preview -->
<script type="text/javascript">
$(".editor").each(function(index){
  var quill = new Quill(this, {
    theme: 'snow'
  });
})

document.querySelector('.SlipForm').addEventListener('submit',function(e){
e.preventDefault()
})
  $(".submit-btn").on("click", function (e) {
e.preventDefault();  
$('.editor .ql-editor').each(function(box){
const box_html = $(this).closest(".boxitem")
box_html.find('textarea').html($(this).html())

//box_html.find('textarea').html();
});

 $.ajax({
        type: "POST",
        url: "output.php",
        data:$('.SlipForm').serialize(), // serializes the form's elements.
        success: function(data)
        {
          const datajson = JSON.parse(data);
          if(datajson['slips']){
        alert("Data is uploaded successfully");
          } 
         // console.log(datajson['slips'])
        // show response from the php script.
        }
    });    
   });  
 const printbtn = document.querySelector('#previewprint');

// on click add block


document.querySelector('#addblock').addEventListener('click',function(e){
  let tablebox = document.querySelector("#imageblockbox tbody");
  let elementCount =tablebox.childElementCount + 1
  console.log()
e.preventDefault()

const html = `<tr class='block${elementCount} blockcontent' data-index='${elementCount}'><th scope='row mb-3'>${elementCount}</th> <th class='title'>  
<input type='text' class='imagetitle' name='title${elementCount}'  class='form-control' required></th>
      <td>  <input type='url' class='imageurl' name='image${elementCount}' class='form-control' required></td>
      <td><div class='col img-box'>
      <button onclick="removeRow(this)" class="close-btn"> &#215;</button>
     
<img src ='https://boltagency.ca/content/images/2020/03/placeholder-images-product-1_large.png' width='100' height='100' id='imageblock' />
</div></td>
    </tr>`;
tablebox.insertAdjacentHTML('beforeend',html);
})
//Close the new append row in table
function getNextSiblings(cur_row){
var nextSibling = cur_row.nextElementSibling;

 while (nextSibling) {
  let dataindex = nextSibling.getAttribute('data-index');
  let currentIndex = dataindex - 1;
  nextSibling.setAttribute('data-index',currentIndex);
  nextSibling.firstElementChild.innerText = currentIndex;
  nextSibling.classList.remove(`block${dataindex}`);
  nextSibling.classList.add(`block${currentIndex}`);
 nextSibling.querySelector('.imagetitle').setAttribute('name',`title${currentIndex}`);
 nextSibling.querySelector('.imageurl').setAttribute('name',`image${currentIndex}`);
    nextSibling = nextSibling.nextElementSibling;
  }
}


function removeRow(button) {



     const currentrow =button.closest('tr');
   //  console.log("iii",currentrow)
getNextSiblings(currentrow);
 currentrow.remove();
}



</script>

<?php 
// }
// else{


//   echo "<div class='contentmid'><h3>The App is not available for this store</div>";
// }

?>
</body>
</html>
