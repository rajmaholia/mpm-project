<?php
require '../sessions.php';
require '../mysql_connector.php';
require '../validators.php';
/*** This section starts or resume the session check if seller is logged in **/
//if(getVar('sellerID')!=null && getVar('seller')!=null){
  $aid = 001;//getVar('sellerID');
  $admin = "admin";//getVar('seller');
  $randomKey = time();
  $imageKey = $admin."".$aid."".$randomKey;
  define("ADMIN_KEY",$imageKey);
//} else {
  //redirect('seller-login');
//}
define("UPLOAD_PATH",'../uploads/');
/*** End **/
/*** Handler form ***/
if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
$files = $_FILES['product-images'];
 $title = test_input($_POST['product_title']);
 $summary = test_input($_POST['product-summary']);
 $categories = $_POST['product-categories'];
 $usual_price = test_input($_POST['usual-price']);
 $listing_price = test_input($_POST['listing-price']);
 $available_stock = test_input($_POST['stock-availability']);
 $psarray = array();
 $imagesarray = array();
 
//This Store Product Specifications as Key Value pairs
 $arrayKeyStr = join('',array_keys($_POST));
 $pscount = preg_match_all('/product_highlight/',$arrayKeyStr) / 2;
 for($i=1;$i <= $pscount;$i++) {
    $prop = test_input($_POST['product_highlight_key_'.$i]);
    $value = test_input($_POST['product_highlight_value_'.$i]);
   if(empty($prop) || empty($value)) {
     continue;
   } else {
     $psarray[$prop] = $value;
   }
 }
/***** added key value pairs  End ***/

/*** Error handling ***/
$filesError = $titleError = $summaryError = $usualPriceError = $listingPriceError =$listingDiscountError= $availableStockError = $psarrayError = "";
 
 if(count($files["name"])==1 && strlen($files["name"][0])==0){
   $filesError = "Upload at least one image of product";
 }
 if(empty($title)){
   $titleError = "Title is required";
 }
 if(empty($summary)){
   $summaryError = "Summary is required";
 }
 if(empty($usual_price)){
   $usualPriceError = "Required";
 }
 if(empty($listing_price)){
   $listingPriceError = "Required";
 }
 if(empty($psarray)) {
   $psarrayError = "Required at least one specification";
 }
 if(empty($available_stock)){
   $availableStockError = "Please enter available product pieces.";
 }
 if($filesError||$availableStockError || $psarrayError || $titleError || $summaryError || $usualPriceError || $listingPriceError || $listingDiscountError){
   $_SESSION['filesError'] = $filesError;
   $_SESSION['titleError'] = $titleError;
   $_SESSION['summaryError'] = $summaryError;
   $_SESSION['psarrayError'] = $psarrayError;
   $_SESSION['listingPriceError'] = $listingPriceError;
   $_SESSION['listingDiscountError'] = $listingDiscountError;
   $_SESSION['availableStockError'] = $availableStockError;
   header('Location: http://0.0.0.0:8080/admin/add_listing.php');
 } 
 /**** Ended Error handling ***/
 else {
   if(upload_image_handler($files) == true){
    $psarray = json_encode($psarray);
    $imagesarray = json_encode($imagesarray);
    $categories = json_encode($categories);
    $discount = ($usual_price - $listing_price)/$usual_price;
    $discount = floor($discount * 100);
    
    $sql = "insert into Product (product_images,title,summary, specifications,usual_price,listing_price,stock_availability,seller,categories,discount) values ('$imagesarray','$title','$summary','$psarray','$usual_price','$listing_price','$available_stock','$aid','$categories','$discount')";
      if(mysqli_query($conn,$sql)){
        $lastId = mysqli_insert_id($conn);
        $categories = json_decode($categories);
        foreach($categories as $category) {
        $sqlpc = "insert into ProductCategory (product_id,category_id) values ('$lastId','$category')";
         if(!mysqli_query($conn,$sqlpc)) echo mysqli_error($conn);
        header('Location: http://0.0.0.0:8080/admin/object_list.php?table=Product');
       }
      }else {
      echo mysqli_error($conn);
     }
   }//upload_image_handler
 }//else
}//POST

/*** Prify Input ***/

/*** Prify Input  End ***/


function upload_image_handler($files){
  global $imagesarray;
/* This function */
  $target_dir = UPLOAD_PATH;//Target Directory to store files 
  $done = false;
  for($i = 0; $i<count($files["name"]);$i++){
    $targetFile = $target_dir . ADMIN_KEY . basename($files["name"][$i]);
    if(file_exists($targetFile)) {
      $targetFile = $target_dir .ADMIN_KEY."".mt_rand(10000,99999).basename($files["name"][$i]);
    }
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo(
    $targetFile,PATHINFO_EXTENSION));
    $check = getimagesize($files["tmp_name"][$i]);
    if($check!==false) {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
    }
    
    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png"){
      $uploadOk = 0;
    }
    if($uploadOk == 1){
     if(move_uploaded_file($files["tmp_name"][$i],$targetFile)){
       array_push($imagesarray,basename($targetFile,'.$imageFileType'));
       
       $done = true;
     } else{
       $done=false;
     }
    }
  }
  return $done;
}

/**** File Handler ****/
