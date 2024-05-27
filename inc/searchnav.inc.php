

<header>
    <div class="row nav-container">
        <div class="col-sm-12 col-md-6">
            <!-- Placeholder for other content(top left) or empty -->
        </div>
        <nav class="col-sm-12 col-md-6 nav-item">
            <ul>
                <li class="account-dropdown">
                    <?php if (!empty($_SESSION['user_id']) && !empty($_SESSION['user_first_name'])): ?>
                        <a href="#"><i class="fa fa-user"></i><span><?php echo htmlspecialchars($userFirstName); ?></span></a>
                        <span class="account-dropdown-content">
                            <a href="user_dashboard.php">Dashboard</a>
                            <a href="#" onclick="confirmLogout()">Logout</a>
                        </span>
                    <?php else: ?>
                        <a href="#"><i class="fa fa-user"></i><span>Account</span></a>
                        <span class="account-dropdown-content">
                            <a href="newform.php">Register</a>
                            <a href="newlogin.php">Login</a>
                        </span>
                    <?php endif; ?>
                </li>
                <li><a href="wishlist.php"><i class="fa-solid fa-heart"></i><span>Wishlist</span></a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><span>MY CART</span></a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="container-fluid">
    <div class="row search-bar mt-3">
        <div class="col-12 col-lg-2 mb-3"><a href="/"><img src="../img/booklogo1.png" alt="Logo" style="max-height: 100px;"></a></div>
        <div class="col-2 col-lg-1">
            <!-- Bar icon to toggle navbar collapse -->
            <button class="navbar-toggler burgermenu" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class=" fa-sharp fa-solid fa-bars"></i>
            </button>
        </div>
        <form class="col-8 col-lg-7" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="search" class="form-control" placeholder="Search" aria-label="search" name="search">
            <button class="btn btn-primary search" type="submit" name="submit_search">Search</button>
        </form>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <div class="bottom-nav navbar-nav">
                <ul class="flex-container">
                    <li>
                        <a class="nav-link font-weight-bold" href="index.php">Home</a>
                    </li>
                    <li>|</li>
                    <li>
                        <a class="nav-link font-weight-bold" href="AboutUs.php">About Us</a>
                    </li>
                    <li>|</li>
                    <li>
                        <a class="nav-link font-weight-bold" href="product.php">Catalog</a>
                    </li>
                    <li>|</li>
                    <li>
                        <a class="nav-link font-weight-bold" href="ContactUs.php">Contact Us</a>
                    </li>
                    <li>|</li>
                    <li>
                        <a class="nav-link font-weight-bold" href="sub.php">Join Us!</a>
                    </li>
                </ul>
            </div>
            </ul>
        </div>
    </div>
</div>
<link rel="stylesheet" href="css/searchnavStyle.css">

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php";
    }
  }
</script>

