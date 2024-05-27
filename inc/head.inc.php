<?php
session_start();
// Check if the 'message' query parameter is set to 'adminlogout'
if (isset($_GET['message']) && $_GET['message'] == 'adminlogout') {
    echo "<script>alert('Logout successful, Bye admin');</script>";
}
elseif (isset($_GET['message']) && $_GET['message'] == 'logout') {
    echo "<script>alert('You have logged out. Thank you for visiting BookHub!');</script>";
}
?>
<link rel="shortcut icon" type="image/x-icon"  href="../img/favicon.png">
<meta charset="utf-8">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
  integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<!--Font Awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Bootstrap JS-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- ScrollReveal.js library -->
<script src="https://unpkg.com/scrollreveal"></script>
<script src="js/home.js"></script>



