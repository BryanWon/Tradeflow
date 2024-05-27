<!DOCTYPE html>
    <html lang="en">
        <head>
        <?php
            session_start(); // Start the session if not already started

            include "inc/headproduct.inc.php";
            include 'lib/connection.php'; // Ensure you include your database connection here

            $isLoggedIn = isset($_SESSION['user_id']); // true if logged in, false otherwise

            // Retrieve products to display
            $sql = "SELECT * FROM product";

            // Check if the deal_category parameter is set and not empty
            if (isset($_GET['deal_category']) && !empty($_GET['deal_category'])) {
                $deal_category = $_GET['deal_category'];
                // Modify the SQL query to filter products by the specified deal category
                if (strpos($sql, 'WHERE') !== false) {
                    $sql .= " AND deal_category = '$deal_category'";
                } else {
                    $sql .= " WHERE deal_category = '$deal_category'";
                }
            }

            // Check if the category parameter is set and not empty
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $category = $_GET['category'];
                // Modify the SQL query to filter products by the specified category
                if (strpos($sql, 'WHERE') !== false) {
                    $sql .= " AND catagory = '$category'";
                } else {
                    $sql .= " WHERE catagory = '$category'";
                }

            }


            // Check if the search form has been submitted
            if (isset($_POST['submit_search']) && !empty($_POST['search'])) {
                // Retrieve the search term and sanitize it
                $name = trim($_POST['search']);
                // Prepared statement to prevent SQL injection
                $stmt = $conn->prepare("SELECT * FROM product WHERE name LIKE CONCAT('%', ?, '%')");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $conn->query($sql);
            }

                // Retrieve product details from the database
                $product = [];
                if ($productId) {
                    $stmt = $conn->prepare("SELECT * FROM project.product WHERE id = ?");
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $product = $result->fetch_assoc();
                    }
                    $stmt->close();
                }
            ?>

            <title>Products</title>
            <link rel="stylesheet" href="css/product.css">
            <script defer src="js/product.js"></script>
        </head>
        
        <body>
            <main class="product-container mt-3 mb-5">
            <?php include "inc/searchnav.inc.php";?>

                <!-- BREADCRUMB -->
                <div class="breadcrumb mt-5">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li>Collections</li>
                        <li>Products</li>
                    </ul>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-10 title"><h2>Products</h2></div>
                </div>


                <!-- MAIN BODY -->
                <div class="row">
                    <!-- SIDE BAR -->
                    <div class="col-lg-2 mt-3 side-bar">
                        <div class="Deals">
                            <h4>Deals</h4>
                            <ul>
                            <li><a href="product.php?deal_category=top_deal" class="deal-link" data-deal-category="top_deal">Top Deals</a></li>
                            <li><a href="product.php?deal_category=top_seller" class="deal-link" data-deal-category="top_seller">Top Sellers</a></li>
                            <li><a href="product.php?deal_category=most_viewed" class="deal-link" data-deal-category="most_viewed">Most Viewed</a></li>
                            </ul>
                        </div>
                        <div class="category">
                            <h4>Category</h4>
                            <ul>
                                <li><a href="product.php?category=Fiction">Fiction</a></li>
                                <li><a href="product.php?category=Mystery%20%26%20Crime">Mystery & Crime</a></li>
                                <li><a href="product.php?category=Romance">Romance</a></li>
                                <li><a href="product.php?category=Fantasy">Fantasy</a></li>
                                <li><a href="product.php?category=Horror">Horror</a></li>
                                <li><a href="product.php?category=Biography">Biography</a></li>
                                <li><a href="product.php?category=Poetry">Poetry</a></li>
                                <li><a href="product.php?category=Drama">Drama</a></li>
                                <li><a href="product.php?category=Manga">Manga</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- MAIN BAR-->
                    <div class="col-sm-12 col-lg-10 mt-3 main-content">
                        <div class="filter-container">
                            <ul class="grid-container">
                                <li class="active"><i class="fa-sharp fa-solid fa-grip icon"></i></li>
                                <li><i class="fa-sharp fa-solid fa-list icon"></i></li>
                            </ul>
                            <div class="drop-down">
                                <label for="filter-type">Sort By:</label>
                                <select class="filter-type" id="filter-type">
                                    <option>Featured</option>
                                    <option>Name A-Z</option>
                                    <option>Name Z-A</option>
                                    <option>Price: low to high</option>
                                    <option>Price: high to low</option>
                                    <option>Oldest to newest</option>
                                    <option>Newest to Oldest</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                        <?php
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 mb-5 item-grid">
                                    <a class="item-description" href="productDetail.php?product_id=<?php echo $row['id']; ?>">
                                        <img class="img-fluid mx-auto img-file" src="admin/product_img/<?php echo $row['imgname']; ?>" alt="">
                                        <h6><?php echo $row['name']; ?></h6>
                                        <p class="price">$<?php echo $row['Price']; ?></p>
                                    </a>
                                    <div class="star-container">
                                    <?php
                                        // Retrieve the rating value for the current product
                                        $rating = $row['rating'];

                                        // Loop through each star and determine whether to display solid or regular star icon
                                        for ($i = 1; $i <= 5; $i++) {
                                            // Determine the class for the star icon based on the rating value
                                            $starClass = ($i <= $rating) ? 'fa-solid' : 'fa-regular';

                                            // Output the star icon with the appropriate class
                                            echo "<i class='fa-star $starClass' style='color: #FFD43B;'></i>";
                                        }
                                        ?>
                                    </div>
                                    
                                    <ul class="button-container mt-3">
                                        <li>
                                            <button onclick="addToCart(<?php echo $row['id']; ?>)" class="btn" aria-label="cart">
                                                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button onclick="addToWishlist(<?php echo $row['id']; ?>)" class="btn" aria-label="wishlist">
                                                <i class="fa-regular fa-heart" aria-hidden="true"></i>
                                            </button>
                                        </li>
                                        <li>
                                        <button class="btn" data-product-id="<?php echo $row['id']; ?>" aria-label="details" >
                                            <i class="fa-solid fa-magnifying-glass-plus details-btn" aria-hidden="true"></i>
                                        </button>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                                }
                            } else {
                                echo "<p>No products found.</p>";
                            }
                        ?>
                        </div>
                        <div class="item-list">
                            <div class="row">
                            <?php
                            // Reset the pointer to the beginning of the result set
                            $result->data_seek(0);
                            
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col-12 mb-5 item-list-item">
                                        <div class="row">
                                            <div class="col-md-4 img-container">
                                                <img class="img-fluid img-file" src="admin/product_img/<?php echo $row['imgname']; ?>" alt="">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="item-details-container">
                                                    <h2><?php echo $row['name']; ?></h2>
                                                    <p><?php echo $row['description']; ?></p>
                                                    <p class="price">$<?php echo $row['Price']; ?></p>
                                                    <ul class="button-container list">
                                                        <li>
                                                            <button onclick="addToCart(<?php echo $row['id']; ?>)" class="btn" aria-label="cart">
                                                                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i> Add to Cart
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button onclick="addToWishlist(<?php echo $row['id']; ?>)" class="btn" aria-label="wishlist">
                                                            <i class="fa-regular fa-heart" aria-hidden="true"></i> Add to Wishlist
                                                            </button>
                                                        </li>
                                                        <li>
                                                        <button class="btn" onclick="showProductOverlay(<?php echo $row['id']; ?>)" aria-label="details">
                                                            <i class="fa-solid fa-magnifying-glass-plus details-btn" aria-hidden="true"></i> View Image
                                                        </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                } else {
                                    echo "<p>No products found.</p>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row page-container">
                            <div class="col-xs-12 col-md-4 page-detail"><span>1 - 6 product(s) of 20</span></div>
                            <div class="col-xs-12 col-md-8 page-list">
                                <a href="#"><i class="fa-solid fa-chevron-left"></i><span>Previous</span></a>
                                <span class="active">1</span>
                                <a href="#"><span>2</span></a>
                                <a href="#"><span>3</span></a>
                                <a href="#"><span>Next</span><span class="arrow-right"><i class="fa-solid fa-chevron-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
            <div class="overlay" id="productOverlay" style="visibility: hidden;">
                <div class="overlay-content">
                    <i class="fa-solid fa-xmark" onclick="closeProductOverlay()"></i>
                    <div>
                        <div >
                            <h1>null</h1>
                            <img src="#" class="product-img img-fluid mx-auto">
                        </div>  
                    </div>
                </div>
            </div> 

            
            <?php
            include "inc/footer.inc.php";
            ?> 

            <script>
                <?php
                // Reset the pointer to the beginning of the result set
                $result->data_seek(0);

                // Start JavaScript variable assignment
                echo 'var productData = {};';
                if ($result->num_rows > 0) {
                    // Output data of each row as JavaScript variables
                    while($row = $result->fetch_assoc()) {
                        echo 'productData[' . $row['id'] . '] = {';
                        echo 'name: "' . addslashes($row['name']) . '", ';
                        echo 'imgname: "' . addslashes($row['imgname']) . '"';
                        echo '};';
                    }
                }
                ?>

                var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
                function addToCart(productId) {
                    if (isLoggedIn) {
                        window.location.href = "add_to_cart.php?product_id=" + productId;
                    } else {
                        alert("Please login before adding items to your cart.");
                        // Store the product ID in session via AJAX call or directly pass as URL parameter
                        window.location.href = "newlogin.php?redirect=product&product_id=" + productId;
                    }
                }

                function addToWishlist(productId) {
                    if (isLoggedIn) {
                        window.location.href = "add_to_wishlist.php?product_id=" + productId;
                    } else {
                        alert("Please login before adding items to your wishlist.");
                        window.location.href = "newlogin.php?redirect=product&product_id=" + productId;
                    }
                }

                // Check if wishlist_exists session variable is set
                <?php if(isset($_SESSION['wishlist_exists'])): ?>
                    alert('This item is already in your wishlist.');
                <?php
                    // Unset the session variable after displaying the pop-up
                    unset($_SESSION['wishlist_exists']);
                ?>
                <?php endif; ?>
                
                // JavaScript for updating URL parameters dynamically
                function updateURLParameter(param, value) {
                    const url = new URL(window.location.href);
                    url.searchParams.set(param, value);
                    window.history.replaceState({}, '', url);
                }

                // JavaScript to handle clicking on deal category links
                const dealLinks = document.querySelectorAll('.deal-link');
                dealLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        const dealCategory = event.target.dataset.dealCategory;
                        updateURLParameter('deal_category', dealCategory);
                    });
                });

                function updateCategory(category) {
                    updateURLParameter('category', category);
                    // Optionally, you can reload the page after updating the URL
                    // window.location.reload();
                }

                function updateURLParameter(param, value) {
                    const url = new URL(window.location.href);
                    url.searchParams.set(param, value);
                    window.history.replaceState({}, '', url);
                }

            </script>
        </body>
    </html>