<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1\dist\css\bootstrap.css">
    <link rel="stylesheet" href="css/free/mdb.min.css" />
    <link rel="stylesheet" href="css/modules/lightbox.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="style/css.css">
    <title>LOGIN</title>
</head>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

<body>
    
<?php include("menu/menu_login.php");?>
    <!-- Section: Design Block -->
    <section class="text-center text-lg-start">
        <style>
            body {
                background-color: #eee;
            }
            
            .cascading-right {
                margin-right: -50px;
            }
            
            @media (max-width: 991.98px) {
                .cascading-right {
                    margin-right: 0;
                }
            }
        </style>

       
        <div class="container py-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card cascading-right" style=" background: hsla(0, 0%, 100%, 0.55); backdrop-filter: blur(30px); ">
                        <div class="card-body p-5 shadow-5 text-left">
                            <h2 class="fw-bold mb-5"> เข้าสู่ระบบ</h2>
                            <form action="login_send.php" method="post">
                                <!-- 2 column grid layout with text inputs for the first and last names -->

                                <div class="form-outline mb-3">
                                    <i class="bi bi-person"></i>
                                    <label class="form-label" for="form3Example3">Username</label>
                                    <input type="text" name="username" id="form3Example3" class="form-control" />
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-3">
                                    <i class="bi bi-key"></i>
                                    <label class="form-label" for="form3Example4">Password</label>
                                    <input type="password" name="password" id="myInput" class="form-control" />
                                </div>

                              
                                <div class="form-check d-flex justify-content-left mb-4">
                                    <input class="form-check-input me-2" type="checkbox" value="" onclick="myFunction()" id="form2Example34"   />
                                    <label class="form-check-label" for="form2Example34">
                                        แสดงรหัสผ่าน
                                    </label>
                                </div>
                            
                                <div class="form-check d-flex justify-content-left mb-4">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                                    <label class="form-check-label" for="form2Example33">
                                        จดจำรหัสผ่าน
                                    </label>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    เข้าสู่ระบบ
                                

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://images.pexels.com/photos/1521306/pexels-photo-1521306.jpeg?cs=srgb&dl=pexels-kirsten-b%C3%BChne-1521306.jpg&fm=jpg" class="w-100 rounded-5 shadow-4" alt="" />
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password"){
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>