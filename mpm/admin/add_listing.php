<?php 
require "../sessions.php";
require "../mysql_connector.php";
//if(getVar('ID')!=null && getVar('')!=null){
  $adminid = 001;//getVar('ID');
  $admin = "admin"; //getVar('');
  $adminKey = $admin."".$adminid;
  define("ADMIN_KEY",$adminKey);
//} else {
  //edirect('admin-login');
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Flashkart</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
   <meta http-equiv="Expires"  content="0"/>
  <link rel="stylesheet" href="http://0.0.0.0:8080/css/index.css">
  <?php include '../fonts/googlefont.php'?>


    <style>
    * {
      box-sizing: border-box;
    }
      .container,body {
        background-color: #e7ebec;
        margin:0 !important;
        padding:0
      }
#img-preview {
  width: 100%;   
  margin-bottom: 20px;
 
}
#img-preview img {  
  width: 100%;
  height: auto; 
  display: inline-block;   
  margin:1px;
  border:5px solid #bec7c9;
  border-radius:5px;
}
.visually-hidden {
  visibility: hidden;
}
main {
  padding:5px;
}
input,textarea {
  width:100%;
  height:40px;
}
textarea {
  height:auto
}
input:focus,textarea:focus {
  outline: 2px solid var(--bgcolor-nav);
}
button.add-ps,button[type="submit"] {
  float:right;
margin-top:3px;
padding:10px 20px;
font-size: 16px;
font-family:serif;
}
.error::before{
  content:"i";
  background-color: var(--bgcolor-nav);
  padding:0 5px;
  border-radius:50%;
  color:white;
  margin-right:4px;
}
.error {
  color:red;
  font-size: 12px;
}

    </style>
 </head>
 <body>
   <div class="container">
     <?php include '../components/nav_all.php';
     createNav('none','Flashkart Admin','16px'); ?>
     <main>
       <h1>Add Listing</h1>
       
       <form action="<?php echo htmlspecialchars('add_listing_handler.php'); ?>" enctype="multipart/form-data" method="post">
        <h3>1. Upload Image</h3>
        <div>
         <div id="img-preview"></div>
         <input type="file" accept="image/*" name="product-images[]" id="chooseFile" multiple>
         <?php if(isset($_SESSION['filesError'])){
             echo "<span class='error'>". $_SESSION['filesError']."</span>"
            ;} ?>
        </div>
        <div class="field">
          <h3>2. Title</h3>
          <lable for="product_title" class="visually-hidden">Title</lable>
          <input type="text" name="product_title" id="product_title">
         <?php if(isset($_SESSION['titleError'])){
             echo "<span class='error'>". $_SESSION['titleError']."</span>"     ;} ?>
        </div>
        <div class="field" id="product_specification">
          <h3>3. Product Highlights</h3>
          <div class="product-specification-field">
            <span class="d-flex ">
            <input type="text" name="product_highlight_key_1" placeholder="specification eg. Color">
            <input type="text" name="product_highlight_value_1" placeholder="value eg . Red">
            </span>
            
          </div>
          <?php 
          if(isset($_SESSION['psarrayError'])){
           echo " <span class='error'>". $_SESSION['psarrayError']."</span>";
          } ?>
          <button class="add-ps fk-btn bg-theme text-white" onclick="addPsp()" id="#add-ps" type="button">Add</button>
        </div>
        
        <div class="field" id="product-summary">
          <h3>4. Product Summary</h3>
          <textarea name="product-summary" id="" cols="30" rows="5"></textarea>
          <?php if(isset($_SESSION['summaryError'])){
             echo "<span class='error'>". $_SESSION['summaryError']."</span>"
            ;} ?>
        </div>
        <div class="field" id="product-summary">
          <h3>5. Category</h3>
              <select name="product-categories[]" id="id-product-categoties" class="class-form-control" multiple>
<?php
$sql = "select catid,title from Category";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
     echo "<option value='".$row['catid']."'>".$row['title']."</option>";
       }
 ?>
              </select>
        </div>
        <div class="field" id="product-prices">
          <h3>5. Pricing</h3>
          <span class="d-flex">
          <input type="number" id="usual-price" name="usual-price" placeholder="Usual Price eg. 1000" >
          <input type="number" id="listing-price" name="listing-price" placeholder="Listing Price eg. 200" >
          </span>
          <?php if(isset($_SESSION['listingPriceError']) or  isset($_SESSION['usualPriceError'])){
             echo "<span class='error'>". $_SESSION['listingPriceError']."</span>"
            ;} ?>
        </div>
        <div class="field" id="product-availability">
          <h3>5. Stock Availability</h3>
          <input type="number" id="stock-availability" name="stock-availability" placeholder="Availabile Stocks eg . 50" >
         <?php if(isset($_SESSION['availableStockError'])){
             echo "<span class='error'> ". $_SESSION['availableStockError'] ."</span>"
            ;} ?>
        </div>
        <button class="fk-btn bg-theme text-white" type="submit">Submit</button>
       </form>
     </main>
     
   </div>
   <script>
    let chooseFile =  document.getElementById('chooseFile');
    let imgPreview = document.getElementById('img-preview');
    chooseFile.addEventListener('change',getImgData,false);
    
  function getImgData() {
    let noOfFiles = chooseFile.files.length
    if (noOfFiles > 0) {
      for(var i = 0;i<noOfFiles;i++){
      let file = chooseFile.files[i];
      const fileReader = new FileReader();
      fileReader.readAsDataURL(file);
      fileReader.addEventListener("load", function () {
        imgPreview.style.display = "block";
        let $img = document.createElement('img');
        $img.style.width = "100px";
        $img.src = this.result;
        imgPreview.appendChild($img);
      });    
    }
    }
  }
  

  function addPsp(){
   if(localStorage.getItem('count')==null){
     localStorage.setItem('count',2);
   }
   let count = localStorage.getItem('count');
    let productSpecificationField =  document.getElementsByClassName('product-specification-field')[0];
   let childEl = document.createElement("span");
   childEl.className = "d-flex";
   childEl.innerHTML =  `<span class="d-flex">
          <input type="text" name="product_highlight_key_${count}" placeholder="specification eg. Color">
          <input type="text" name="product_highlight_value_${count}" placeholder="value eg . Red">
          </span> `;
      productSpecificationField.appendChild(childEl);
    localStorage.setItem('count', count+1);
  }

   </script>

 </body>
 </html>