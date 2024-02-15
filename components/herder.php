
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style/css.css">
</head>
<body>
 
<div class="container" > 
  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
      <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner"> 
      <div class="carousel-item active">
        <img src="https://inwfile.com/s-dy/4qie2d.png" alt="" style="width:100%; height:300px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="https://setting.ihavecpu.com/uploads/article/shop1/7925137498935890176721847.jpg" alt="" style="width:100%;height:300px; object-fit:cover;">
      </div>
      <div class="carousel-item">
        <img src="https://cs.lnwfile.com/_/cs/_raw/d6/0l/zy.jpg" alt="" style="width:100%;height:300px; object-fit: cover;">
      </div>
    </div>

    <!-- Left and right controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
 </div>

</body>
</html>
