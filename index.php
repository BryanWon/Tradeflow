<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include "inc/head.inc.php";
?>
  <title>Tradeflow Capital Management</title>
  <link href="css/Homepagestyle.css" rel="stylesheet">
  <?php
  include "inc/nav.inc.php";
  ?> 
</head>

<body>
<main>
<div class="carousel-container">
  <div id="demo" class="carousel slide fixed-controls-carousel" data-ride="carousel" data-interval="1500">

    <!-- Indicators -->
    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class="active"></li>
      <li data-target="#demo" data-slide-to="1"></li>
      <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
      <div class="carousel-item active" title="carousel pictures">
        <img src="../img/satimg1.jpg" alt="bookopened" class="fixed-size-img">
      </div>
      <div class="carousel-item">
        <img src="../img/satimg1.jpg" alt="Bookshelf" class="fixed-size-img">
      </div>
      <div class="carousel-item">
        <img src="../img/satimg1.jpg" alt="colouredbooks" class="fixed-size-img">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="sr-only">Previous</span> 
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="sr-only">Next</span>
    </a>

    <div class="carousel-caption justify-content-center align-items-center" title="carousel caption">
      <h1 class="text-light">Tradeflow Capital Management</h1>
      <a class="button shop-now" href="product.php">
      Sign Up Here
     <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
        <path clip-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" fill-rule="evenodd"></path>
    </svg>
</a>
</div>
</div>
</div>

<div id="bodytext">
  <div class="container">
    <!-- Text Row -->
    <div class="row justify-content-center text-row">
      <div class="col-md-4 col-sm-6 text-center">
        <h1 class="Topics text-dark">Real-Time Tracking</h1>
        <div class="details">
          <p>Provide live updates on port schedules and cargo statuses.</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 text-center">
        <h1 class="Topics text-dark">Predictive Scheduling</h1>
        <div class="details">
          <p>Offer predictions on arrival and departure times based on historical data and current conditions.</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 text-center">
        <h1 class="Topics text-dark">Analytics and Reporting</h1>
        <div class="details">
          <p>Provide detailed reports and analytics on port operations, cargo movements, and delivery performance.</p>
        </div>
      </div>
    </div>
    <!-- Image Row -->
    <div class="row justify-content-center">
      <div class="col-md-4 col-sm-6 text-center">
        <div class="img1">
          <a href="product.php?deal_category=top_deal"><img src="../img/satimg1.jpg" class="img-fluid fixed-height-img" alt="responsive image"></a>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 text-center">
        <div class="img1">
          <a href="product.php?deal_category=top_seller"><img src="../img/satimg1.jpg" class="img-fluid fixed-height-img" alt="responsive image"></a>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 text-center">
        <div class="img1">
          <a href="product.php?deal_category=most_viewed"><img src="../img/satimg1.jpg" class="img-fluid fixed-height-img" alt="responsive image"></a>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
<script src="js/home.js"></script>
<?php
include "inc/footer.inc.php";
?> 

</body>
</html>
