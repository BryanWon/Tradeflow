<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include "inc/head.inc.php";
?>
  <title>Tradeflow Capital Management</title>
  <link href="css/Homepagestyle.css" rel="stylesheet">
  <link href="css/loginregister.css" rel="stylesheet">
  <?php
  include "inc/nav.inc.php";
  ?> 
</head>

<body>
        <?php
            include "inc/nav.inc.php";
        ?>
        <br>
        <br>
            <div class="cont">
                <form class="form sign-in" action="#" method="post">
                    <h2>Welcome</h2>
                    <label>
                        <span>Email</span>
                        <input required maxlength="45" type="email" id="email" name="email" class="form-control">
                    </label>
                    <label>
                        <span>Password</span>
                        <input required type="password" id="pwd" name="pwd" class="form-control">
                    </label>
                    <p class="forgot-pass">Forgot password?</p>
                    <button type="button" class="submit">Sign In</button>
                </form>
                <div class="sub-cont">
                    <div class="img">
                        <div class="img__text m--up">
                        
                            <h3>Don't have an account?<h3>
                                <h3>Please Sign up!<h3>
                        </div>
                        <div class="img__text m--in">
                        
                            <h3>If you already have an account, just sign in.<h3>
                        </div>
                        <div class="img__btn">
                            <span class="m--up">Sign Up</span>
                            <span class="m--in">Sign In</span>
                        </div>
                    </div>
                    <form class="form sign-up" action="#" method="post">
                        <h2>Create your Account</h2>
                        <label>
                            <span>First Name</span>
                            <input maxlength="45" type="text" id="fname" name="fname" class="form-control">
                        </label>
                        <label>
                            <span>Last Name</span>
                            <input required maxlength="45" type="text" id="lname" name="lname" class="form-control">
                        </label>
                        <label>
                            <span>Email</span>
                            <input required maxlength="45" type="email" id="email" name="email" class="form-control">
                        </label>
                        <label>
                            <span>Select Membership Type</span>
                            <select name="membershipType" id="membershipType" class="form-select">
                                <option value="free">Free Tier</option>
                                <option value="regular">Regular Tier</option>
                                <option value="premium">Premium Tier</option>
                            </select>
                        </label>
                        <label>
                            <span>Password</span>
                            <input required type="password" id="pwd" name="pwd" class="form-control">
                        </label>
                        <label>
                            <span>Confirm Password</span>
                            <input required type="password" id="pwd_confirm" name="pwd_confirm" class="form-control">
                        </label>
                        <button type="button" class="submit">Sign Up</button>
                    </form>
                </div>
            </div>

            <script>
                document.querySelector('.img__btn').addEventListener('click', function() {
                    document.querySelector('.cont').classList.toggle('s--signup');
                });
            </script>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
  </main>
  <!-- Footer -->


