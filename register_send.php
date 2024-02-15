<script src="sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<?php 

echo '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

ini_set('Display_errors',1);
error_reporting(~0);
include("connection/connect.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
// เช็คว่ามีข้อมูลนี้อยู่หรือไม่

	$check = "select * from users  where username = '$username' ";
    $result = mysqli_query($con, $check) or die(mysqli_error($con));
		$num=mysqli_num_rows($result); 
        if($num > 0)   		
        {
//ถ้ามี username นี้อยู่ในระบบแล้วให้แจ้งเตือน
echo "<script>
$(document).ready(function() {
  Swal.fire({
    title: 'Error',
    text: 'มีผู้ใช้ Username นี้แล้ว กรุณาสมัครใหม่อีกครั้ง !',
    icon: 'error',
    timer: 3000,
    showConfirmButton: false
  });
});
setTimeout(function(){
  window.location = 'register.php';
}, 3000);
</script>";

		}else{
      date_default_timezone_set('Asia/Bangkok');
      $date = date("Ymd");
      $numrand = (mt_rand());
      $username = $_POST["username"];
      $password = $_POST["password"];
      $first_name = $_POST["first_name"];
      $last_name = $_POST["last_name"];
      $level = $_POST["level"];
      $email = $_POST["email"];
      $phone = $_POST["phone"];

      // $img = $_POST["img"];
      $upload=$_FILES['img'];
if($upload <> '') {   //not select file
//?โฟลเดอร์ที่จะ upload file เข้าไป 
$path="users/img/";  

//?เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
 $type = strrchr($_FILES['img']['name'],".");
	
//?ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
$newname = $date.$numrand.$type;
$path_copy=$path.$newname;
$path_link="users/img/".$newname;

//คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
move_uploaded_file($_FILES['img']['tmp_name'],$path_copy);  	
	}
       
      

$sql = "INSERT INTO users (img,username,password,first_name,last_name,level,email,phone) 
VALUES ('$newname','$username','$password','$first_name','$last_name','$level','$email','$phone')";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
if($result){

  //! และกระโดดกลับไปหน้าฟอร์ม

    if($result){  
      echo "<script>
                            $(document).ready(function() {
                              Swal.fire({
                                title: 'Success',
                                text: 'You are now register in as a user!',
                                icon: 'success',
                                timer: 2000,
                                allowOutsideClick:false,
                                showConfirmButton: false
                              });
                            });
                            setTimeout(function(){
                              window.location = 'login.php';
                            }, 2000);
                          </script>";
      }
      else{
  //!ถ้าบันทึกไม่สำเร็จแสดงข้อความ Error และกระโดดกลับไปหน้าฟอร์ม
          echo "<script type='text/javascript'>";
          echo "alert('Error!');";
          echo "window.location='register.php';";
        echo "</script>";
      }

}
}
    
//ปิดการเชื่อมต่อกับฐานข้อมูล


 ?>