<?php 
ob_start();
session_start();
$con = mysqli_connect("localhost","root","123456asdzxc","itshop") or die("Error:   " . mysqli_error($conn));
mysqli_query($con,"SET NAMES 'utf8'");
?>
  
  <?php 
    if(isset($_SESSION["user_id"])){ // session money update
      $sql="SELECT 	money,img,first_name,last_name FROM users WHERE user_id='".$_SESSION["user_id"]."'";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result)==1){
      $row = mysqli_fetch_array($result);
      $_SESSION["money"] = $row["money"];
      $_SESSION["img"] = $row["img"];
      $_SESSION["first_name"] = $row["first_name"];
      $_SESSION["last_name"] = $row["last_name"];

      

  }

  }
  
  ?>
