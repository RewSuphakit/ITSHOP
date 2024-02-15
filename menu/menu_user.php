<?php
include_once("../connection/connect.php");

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  // Redirect to the login page or display an error message
  header("Location: ../login.php");
  exit();
}
?>

<?php if (isset($_SESSION["user_id"]) and isset($_SESSION["level"])) { ?>

  <?php if (isset($_GET['error'])) : ?>
    <p><?php echo $_GET['error']; ?></p>
  <?php endif ?>

  <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ITSHOP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
  
  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background-color: #FFFFFF;
    }

    img.resize {
      width: 40px;
      height: 40px;
      border: 0;
    }

    .cart-count {
      background-color: #ff0000;
      color: #fff;
      padding: 2px 5px;
      border-radius: 50%;
      font-size: 12px;
      margin-left: 1px;
    }
  </style>
</head>

<body>

  <?php
  $cartQuantity = 0;

  if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
      $cartQuantity += $item['quantity'];
    }
  }
  ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary  fixed-top ">
  <div class="container">
    <a class="navbar-brand" href="product.php">ITSHOP</a>
    <!-- ซ่อนชื่อและตะกร้าสินค้าเมื่อเป็นหน้าจอขนาดเล็ก -->
    <div class="d-lg-none ml-auto">
      <a href="cart.php" class="nav-link d-lg-block">
      <i class="fas fa-shopping-cart"></i>
      <?php echo ($cartQuantity > 0) ? "<span class='cart-count'>$cartQuantity</span>" : ""; ?>
    </a></div>
    <div class="d-lg-none ml-auto">
      <i class="fas fa-user"></i>
      <?php echo $row["first_name"]; ?>
    </div>
    <!-- /ซ่อนชื่อและตะกร้าสินค้าเมื่อเป็นหน้าจอขนาดเล็ก -->

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ">
        <li class="nav-item navbar ">
          <a class="nav-link" href="product.php"><i class="fas fa-home"></i> หน้าหลัก</a>
        </li>
        <li class="nav-item navbar">
          <a class="nav-link d-none d-lg-block" href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <?php echo ($cartQuantity > 0) ? "<span class='cart-count'>$cartQuantity</span>" : ""; ?>
          </a>
        </li>
        <li class="nav-item navbar">
          <div class="nav-link d-none d-lg-block" >
            <i class="fas fa-user"></i>
            <?php echo $row["first_name"]; ?>
          </div>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="img/<?php echo $row['img']; ?>" alt="" style="object-fit: cover;" class="resize rounded-circle">
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="profile.php<?php $user_id ?>"><i class="fas fa-address-card"></i> ข้อมูลส่วนตัว</a></li>
              <li><a class="dropdown-item" href="order_history.php"><i class="fas fa-history"></i> รายการคำสั่งซื้อ</a></li>
              <li><a class="dropdown-item"><i class="fas fa-dollar-sign"></i> จำนวนเงิน <?php echo "" . number_format($row["money"]) . ""; ?> บาท</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" type="button" onclick="logout()"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script>
  // เมื่อเลื่อนหน้าจอ
  window.onscroll = function () {
    scrollFunction();
  };

  function scrollFunction() {
    // หาก scroll ลงมา
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      // ให้เมนูมีพื้นหลังสีขาว
      document.querySelector(".navbar").style.backgroundColor = "#fff";
    } else {
      // หาก scroll ไปบน
      // ให้เมนูมีพื้นหลังโปร่งใส
      document.querySelector(".navbar").style.backgroundColor = "transparent";
    }
  }
</script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    function logout() {
      Swal.fire({
        title: 'แน่ใจหรือป่าว?',
        text: "ออกจากระบบ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช้, ออกจากระบบ!',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.value) {
          Swal.fire({
            allowOutsideClick: false,
            title: 'ออกจากระบบสำเร็จ!',
            icon: 'success',
            confirmButtonText: 'ตกลง'
          }).then(function() {
            window.location.href = "../logout.php";
          });
        }
      });
    }
  </script>
<br><br><br>
</body>

</html>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
      function logout() {
        Swal.fire({
          title: 'แน่ใจหรือป่าว?',
          text: "ออกจากระบบ",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ใช้, ออกจากระบบ!',
          cancelButtonText: 'ยกเลิก'
        }).then((result) => {
          if (result.value) {
            Swal.fire({
              allowOutsideClick: false,
              title: 'ออกจากระบบสำเร็จ!',
              icon: 'success',
              confirmButtonText: 'ตกลง'
            }).then(function() {
              window.location.href = "../logout.php";
            });
          }
        });
      }
    </script>
  </body>

  </html>

<?php } else { ?>
  <?php
  echo "<script>";
  echo "alert(' กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ !!');";
  echo "window.location='../login.php';";
  echo "</script>";
  ?>
<?php } ?>