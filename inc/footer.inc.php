
<footer class="bg-dark text-white py-2">
  <div class="container-fluid">
    <div class="row col-10 mx-auto">
      <div class="col categories">
          <h1 class="mt-3 mb-3">CATEGORIES</h1>
          <ul>
              <li><a class="nav-link text-white" href="#">Fiction</a></li>
              <li><a class="nav-link text-white" href="#">Mystery & Crime</a></li>
              <li><a class="nav-link text-white" href="#">Romance</a></li>
              <li><a class="nav-link text-white" href="#">Fantasy</a></li>
              <li><a class="nav-link text-white" href="#">Horror</a></li>
              <li><a class="nav-link text-white" href="#">Biography</a></li>
              <li><a class="nav-link text-white" href="#">Poetry</a></li>
              <li><a class="nav-link text-white" href="#">Drama</a></li>
              <li><a class="nav-link text-white" href="#">Manga</a></li>
          </ul>
      </div>
      <div class="col informations">
          <h1 class="mt-3 mb-3">INFORMATION</h1>
          <ul>
              <li><a class="nav-link text-white" href="index.php">Home</a></li>
              <li><a class="nav-link text-white" href="AboutUs.php">About Us</a></li>
              <li><a class="nav-link text-white" href="ContactUs.php">Contact Us</a></li>
              <li><a class="nav-link text-white" href="product.php">Catalog</a></li>
              <li><a class="nav-link text-white" href="subinfo.php">Join Us</a></li>
          </ul>
      </div>
      <div class="col account">
          <h1 class="mt-3 mb-3">MY ACCOUNT</h1>
          <ul>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <li><a class="nav-link text-white" href="user_dashboard.php">My Dashboard</a></li>
            <li><a class="nav-link text-white" href="wishlist.php">Wishlist</a></li>
            <li><a class="nav-link text-white" href="/cart.php">My Cart</a></li>
          <?php else: ?>
            <li><a class="nav-link text-white" href="newlogin.php">Sign In</a></li>
            <li><a class="nav-link text-white" href="form.php">Register</a></li>
          <?php endif; ?>
          </ul>
      </div>
      <!-- Social Media Icons-->
      <div class="col mt-3 mb-3">
        <i class="far fa-envelope"></i> &nbsp;&nbsp;<a href="mailto:someone@example.com" class="text-white">Email Us at BookHub@gmail.com</a>
        <p class="text-white">Follow Us @ BookHub2024</p>
        <i class="fab fa-instagram socialMedia"></i>
        <i class="fab fa-facebook-square socialMedia"></i>
        <i class="fab fa-twitter socialMedia"></i>
      </div>
    </div>
  </div>

  <div class="copyright">
    <p>Copyright &copy; 2024 BookHub Pte. Ltd.</p>
  </div>
</footer>
    <link rel="stylesheet" href="css/footer.css">
