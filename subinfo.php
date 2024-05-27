<?php
session_start();
require 'lib/connection.php';

// Assume the user is not logged in by default
$userLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;

// Handle subscription tier addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    if ($userLoggedIn) {
        // Check if a subscription is already in the cart
        if (!isset($_SESSION['cart']['subscription'])) {
            // Add subscription tier to the session cart
            $subscriptionItem = [
                'item_name' => $_POST['item_name'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'] // Assuming it's always 1 for subscriptions
            ];
            
            // Insert subscription into database (if not exists)
            $subscriptionName = $_POST['item_name'];
            // Fetch subscription tier ID based on the name
            $sql = "SELECT id FROM subscription_tiers WHERE tier_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $subscriptionName);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $subscriptionTier = $result->fetch_assoc();
                $subscriptionId = $subscriptionTier['id'];
                
                // Check if this subscription tier is already in the user's subscription cart
                $checkSql = "SELECT id FROM subscription_cart WHERE userid = ? AND subscriptionid = ?";
                $checkStmt = $conn->prepare($checkSql);
                $checkStmt->bind_param("ii", $userId, $subscriptionId);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();
                
                if ($checkResult->num_rows == 0) {
                    // Insert the subscription into the subscription_cart
                    $insertSql = "INSERT INTO subscription_cart (userid, subscriptionid) VALUES (?, ?)";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->bind_param("ii", $userId, $subscriptionId);
                    $insertStmt->execute();
                    $insertStmt->close();
                }
                $checkStmt->close();
                
                // Now, add to session
                $_SESSION['cart']['subscription'] = $subscriptionItem;
                
                echo '<script type="text/javascript">
                        alert("Subscription added to your cart successfully!");
                        window.location = "cart.php"; // Redirect to cart page
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        alert("Invalid subscription tier selected.");
                        window.location = "subinfo.php";
                      </script>';
            }
            $stmt->close();
        } else {
            // Subscription already in cart
            echo '<script type="text/javascript">
                    alert("You already have a subscription tier in your cart.");
                    window.location = "subinfo.php"; // Stay on the subscription info page
                  </script>';
        }
    } else {
        // Not logged in
        $_SESSION['redirect_url'] = 'subinfo.php'; // The current page
        echo '<script type="text/javascript">
                alert("Please login before subscribing");
                window.location = "newlogin.php";
            </script>';
        exit;
    }
    $conn->close();
    exit; // Prevent further script execution
}
?>


<?php include "inc/subhead.inc.php"; ?>
<?php include "inc/nav.inc.php"; ?>
<!DOCTYPE html>
<html lang="en">

<body>
    <main>
    <div class="sub-container">
        <p><b>Ever Thought of Reading Regularly While Enjoying Exclusive Discounts?</b></p>
        <p><b>Join Our BookHub Membership for a Curated Reading Journey at Great Value!</b></b>
        
            <!-- Subscription Options Section -->
        <div class="container">
            <a class="button" onclick="scrollToSubscribe()">
                <div class="button__line"></div>
                <div class="button__line"></div>
                <span class="button__text">Subscribe Now</span>
                <div class="button__drow1"></div>
                <div class="button__drow2"></div>
            </a>
        </div>
    </div>
    <div class="row membership-container">
        <!-- Basic Tier Card -->
        <form class="col-6 col-lg" action="subinfo.php" method="post">
            <div class="membership-card">
                <h3>Basic Tier: The Novice Nook</h3>
                <p>One book per month from a select list.</p>
                <p>Member-exclusive promo codes.</p>
                <p>5% discount on all additional purchases.</p>
                <!-- Subscription details as described -->
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="item_name" value="Basic Tier: The Novice Nook">
                <input type="hidden" name="price" value="50.00">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" value="Subscribe">Add to Cart</button>
            </div>
        </form>

        <!-- Standard Tier Card -->
        <form class="col-6 col-lg" action="subinfo.php" method="post">
            <div class="membership-card">
                <h3>Standard Tier: The Avid Reader's Retreat</h3>
                <p>Two books per month, with a wider selection range.</p>
                <p>Higher value promo codes.</p>
                <p>10% discount on all additional purchases.</p>
                <p>Early access to sales and promotions.</p>
                <!-- Subscription details as described -->
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="item_name" value="Standard Tier: The Avid Reader's Retreat">
                <input type="hidden" name="price" value="100.00">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" value="Subscribe">Add to Cart</button>
            </div>
        </form>

        <!-- Premium Tier Card -->
        <form class="col-6 col-lg" action="subinfo.php" method="post">
            <div class="membership-card">
                <h3>Premium Tier: The Literary Laureate</h3>
                <p>Three books per month with full access to the catalogue.</p>
                <p>Exclusive high-value promo codes.</p>
                <p>15% discount on all additional purchases.</p>
                <p>Access to exclusive author events and webinars.</p>
                <!-- Subscription details as described -->
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="item_name" value="Premium Tier: The Literary Laureate">
                <input type="hidden" name="price" value="150.00">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" value="Subscribe">Add to Cart</button>
            </div>
        </form>


        <!-- Ultra Tier Card -->
        <form class="col-6 col-lg" action="subinfo.php" method="post">
            <div class="membership-card">
                <h3>Ultra Tier: The Scholar's Sanctuary</h3>
                <p>Two books per month: one for leisure and one educational.</p>
                <p>Special promo codes for textbooks and academic materials.</p>
                <p>20% discount on educational books.</p>
                <p>Free access to online study groups and book clubs.</p>
                <!-- Subscription details as described -->
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="item_name" value="Ultra Tier: The Scholar's Sanctuary">
                <input type="hidden" name="price" value="200.00">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" value="Subscribe">Add to Cart</button>
            </div>
        </form>
    </div>
</main>

    <script>
        function scrollToSubscribe() {
            document.querySelector('.membership-container').scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>