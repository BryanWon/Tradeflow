<!DOCTYPE html>
<html lang="en">
<head>
<?php
  session_start();
  include "inc/head.inc.php";
?>
  <title>BookHub</title>
  <link href="css/Homepagestyle.css" rel="stylesheet">
  <?php
  include "inc/nav.inc.php";
  ?> 
</head>

<body>
<main>
<div class="carousel-container">
  <div id="demo" class="carousel slide fixed-controls-carousel" data-ride="carousel" data-interval="2000">

    <!-- Indicators -->
    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class="active"></li>
      <li data-target="#demo" data-slide-to="1"></li>
      <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
   <!-- The slideshow -->
<div class="carousel-inner">
  <div class="carousel-item active" title="carousel pictures">
    <img src="../img/bookimg.jpg" alt="bookopened" class="fixed-size-img">
  </div>
  <div class="carousel-item">
    <img src="../img/bookshelf.jpg" alt="Bookshelf" class="fixed-size-img">
  </div>
  <div class="carousel-item">
    <img src="../img/bshelf.jpg" alt="colouredbooks" class="fixed-size-img">
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
  

    <div class="carousel-caption justify-content-center align-items-center" title="carosel caption">
      <h1 class="text-light">BookHub</h1>
      <h2 class="text-light">By Students for Students</h2>
      <a class="button shop-now" href="product.php">
      Shop Now
     <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
        <path clip-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" fill-rule="evenodd"></path>
    </svg>
</a>
</div>
</div>
</div>



    <div id="bodytext">
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs">
          <h1 class="Topics text-dark">Today's Deals</h1>
          <div class="details">

            <p>Discover exclusive deals and discounts<br>on a wide range of books, updated daily.</p>
            <div class="img1">
              <a href="product.php?deal_category=top_deal"><img src="../img/cats.jpg" class="img-fluid" alt="responsive image"></a>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs">
          <h1 class="Topics text-dark">Top Sellers</h1>
          <div class="details">

            <p>Explore the books that are flying off the shelves<br>and find out what everyone's reading.</p>
          </div>
          <div class="img1">
            <a href="product.php?deal_category=top_seller"><img src="../img/topsell.jpg" class="img-fluid" alt="responsive image"></a>
          </div>

        </div>


        <div class="col-md-4 col-sm-6 col-xs">
          <h1 class="Topics text-dark">Most Viewed Books</h1>
          <div class="details">

            <p>See what's capturing the interest of our readers<br>with our most viewed books list.</p>

            <div class="img1">
              <a href="product.php?deal_category=most_viewed"><img src="../img/most.jpg" class="img-fluid" alt="responsive image"></a>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/home.js"></script>
  </body>
  </main>
  <!-- Footer -->
<?php
include "inc/footer.inc.php";
?> 

</html>

