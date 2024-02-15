<script src="sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<?php 
echo '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

        if(isset($_POST['username'])){
                //connection
                 include("connection/connect.php"); 
                //รับค่า user & password
                  $username = $_POST['username'];
                  $password =$_POST['password'];
                //query 
                  $sql="SELECT * FROM users Where username='".$username."' and password='".$password."'";

                  $result = mysqli_query($con,$sql);
                
                  if(mysqli_num_rows($result)==1){

                      $row = mysqli_fetch_array($result);

                      $_SESSION["user_id"] = $row["user_id"];
                      $_SESSION["username"] = $row["username"];
                      $_SESSION["level"] = $row["level"];
                   
                      $name = $row['first_name'] . " " . $row['last_name'];
                      if($_SESSION["level"]=="A"){
                        echo "<script>
                          $(document).ready(function() {
                            Swal.fire({
                              title: 'Success',
                              text: 'ตอนนี้คุณเข้าสู่ระบบในฐานะผู้ดูแลระบบแล้ว!',
                              icon: 'success',
                              timer: 2000,
                              allowOutsideClick:false,
                              showConfirmButton: false
                            });
                          });
                          setTimeout(function(){
                            window.location = 'admin/admin_dashboard.php';
                          }, 2000);
                        </script>";
                  
                      } elseif ($_SESSION["level"]=="U"){
                        echo "<script>
                          $(document).ready(function() {
                            Swal.fire({
                              title: 'Success',
                              text: 'You are now logged in as a user!',
                              text: 'ยินดีต้อนรับ {$name}',
                              icon: 'success',
                              timer: 2000,
                              allowOutsideClick:false,
                              showConfirmButton: false
                            });
                          });
                          setTimeout(function(){
                            window.location = 'users/product.php';
                          }, 2000);
                        </script>";
                      }
                  
                    } else {
                      session_destroy();
                      echo "<script>
                        $(document).ready(function() {
                          Swal.fire({
                            title: 'Error',
                            text: 'Incorrect username or password',
                            icon: 'error',
                            timer: 2000,
                            allowOutsideClick:false,
                            showConfirmButton: false
                          });
                        });
                        setTimeout(function(){
                          window.history.back();
                        }, 2000);
                      </script>";
                    }
                  
                  } else {
                    session_destroy();
                    header("Location: login.php");
                  }
?>




