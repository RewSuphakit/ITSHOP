<?php include("menu/menu_login.php"); 
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1\dist\css\bootstrap.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->
    <title>Register</title>
    <style>
        body {
            background-color: #eee;

        }
    </style>
</head>


<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

    <section class="vh-10" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;margin: 30px ;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"> สมัคสมาชิก</p>


                                    <form action="register_send.php" class="mx-1 mx-md-4" method="post" enctype='multipart/form-data'>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <!-- <i class="fas fa-user fa-lg me-3 fa-fw"></i> -->
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" name="username" id="form3Example1c" required class="form-control" />
                                                <label class="form-label" for="form3Example1c">Username</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <!-- <i class="fas fa-lock fa-lg me-3 fa-fw"></i> -->
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password" id="form3Example4c" required class="form-control" />
                                                <label class="form-label" for="form3Example4c">Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <!-- <i class="fas fa-user fa-lg me-3 fa-fw"></i> -->
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="email" id="form3Example1c" required class="form-control" />
                                                <label class="form-label" for="form3Example1c">Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <!-- <i class="fas fa-user fa-lg me-3 fa-fw"></i> -->
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-outline">
                                                        <input type="text" name="first_name" id="form3Example1" required class="form-control" />
                                                        <label class="form-label" for="form3Example1">ชื่อ</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <div class="form-outline">
                                                        <input type="text" name="last_name" id="form3Example2" required class="form-control" />
                                                        <label class="form-label" for="form3Example2">นามสกุล</label>
                                                    </div>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">เพิ่ม รูปภาพ</label>
                                                    <input class="form-control" type="file" name="img" required id="imgInput" >
                                                    <img width="100%" id="previewImg" alt="">
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <input type="hidden" value="U" name="level">
                                        
                                        <input type="hidden" value="-" name="phone">

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" value="upload" class="btn btn-primary btn-lg">ตกลง</button>
                                        </div>


                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-5 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://images.unsplash.com/photo-1533738363-b7f9aef128ce?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80" class="w-100 rounded-5 shadow-4"  alt=" Sample image ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</html>