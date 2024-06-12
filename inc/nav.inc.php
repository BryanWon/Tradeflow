<nav class="navbar navbar-expand-md navbar-light fixed-top custom-navbar" id="banner">
  <div class="container-fluid d-flex flex-column">
      <!-- Your nav structure -->
      <div class="row nav-container">
            <div class="col-sm-12 col-md-6">
              <!-- Placeholder for other content(top left) or empty -->
            </div>
            <nav class="col-sm-12 col-md-6 nav-item">
        </nav>
    </div>
    <!-- Logo link container -->
    <div class="logo">
      <a class="navbar-brand " href="/"> <!-- Use mx-auto to center the logo -->
        <img src="../img/tflogo.png" alt="Logo" style="max-height: 100px;">
      </a>
    </div>

    <!-- Bottom container with other links -->
    <div class="bottom-container d-flex justify-content-end">
      <button class="navbar-toggler" id="navbar-toggler" title="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="nav" class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto me-0">
            <li class="nav-item">
              <a class="nav-link font-weight-bold" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" href="#">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" href="#">Our Team</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" href="ContactUs.php">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" href="#">Join Us!</a>
            </li>
          </ul>
      </div>
    </div>
 </div>
</nav>



<script>
  let lastScrollTop = 0;
  window.addEventListener("scroll", function() {
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    if (currentScroll > lastScrollTop) {
      // Scrolling down
      document.getElementById("banner").classList.add("hidden-navbar");
    } else {
      // Scrolling up
      document.getElementById("banner").classList.remove("hidden-navbar");
    }
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
  }, false);

  function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php";
    }
  }
</script>

  <link rel="stylesheet" href="css/nav.css">