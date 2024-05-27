<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php'; 

include'lib/connection.php';

$confirmationMessage = '';
$errorMessage = '';
$emailSentSuccessfully = false;  // Define the variable and set it to false by default

if (isset($_POST['contact'])) {

    $salutations = $_POST['salutations'] ?? 'Valued Customer';
    $name = $_POST['name'] ?? 'No name given';
    $email = $_POST['email'] ?? 'no-reply@example.com';
    $message = $_POST['message'] ?? 'No message provided';

               $mail = new PHPMailer(true);
               
               try {
                 //Server settings
                 $mail->isSMTP();
                 $mail->Host       = 'smtp.gmail.com';
                 $mail->SMTPAuth   = true;
                 $mail->Username   = 'bbernicecyq@gmail.com';
                 $mail->Password   = 'oaon jitu rcew nxec';
                 $mail->SMTPSecure = 'tls';
                 $mail->Port       = 587;
                 $mail->SMTPDebug = 0;
  
                 //Recipients
                 $mail->setFrom('bbernicecyq@gmail.com', 'BookHub');
                 $mail->addAddress($email); // Add the user's email address
  
                 // Content
                 // $mail->isHTML(true);
                 $mail->Subject = "Contact Form Submission from $name";
                 $fullMessage = "Hello $salutations $name,<br><br>Thanks for contacting us. We'll get back to you as soon as possible.";
                 $mail->Body = $fullMessage;
                 $mail->AltBody = strip_tags(str_replace("<br>", "\r\n", $fullMessage));
             
                 $mail->send();
         
                 // Confirmation message to be displayed on the webpage
                 $confirmationMessage = "Thanks for contacting us. We'll get back to you as soon as possible.";
                 $emailSentSuccessfully = true;  
                } catch (Exception $e) {
                 $messages[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
               }
           } else {
            $messages[] = "No form submission detected.";
           }

// Display the confirmation or error message after the form
if ($confirmationMessage !== '') {
    echo "<p class='confirmation-message'>{$confirmationMessage}</p>";
}
if ($errorMessage !== '') {
    echo "<p class='error-message'>{$errorMessage}</p>";
}

// After your validation and email sending logic
if ($emailSentSuccessfully) {

    // Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO contact_submissions (salutation, name, email, message) VALUES (?, ?, ?, ?)");

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ssss", $salutations, $name, $email, $message);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Record was successfully saved
        echo "Record saved successfully.";
    } else {
        // There was an error saving the record
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "inc/ContactUs.inc.php";
    ?> 
     <?php
    include "inc/nav.inc.php";
    ?> 
</head>

<body>
   
    <main class="container" style="margin-top: 210px;">
        <div class="row">
            <div class="col">
                <hr> <!-- Divider -->
                <div class="got text-center">
                    <h1>Got a Question?</h1>
                    <br>
                    <h2>We'd Love to Hear From You</h2>
                </div>

                <!-- Confirmation or error messages -->
<?php if ($confirmationMessage): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $confirmationMessage; ?>
    </div>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

                <form action="ContactUs.php" method="post">
                    <div class="mb-3" style="padding-top: 30px;">
                        <label for="salutations" class="form-label">Salutations:</label>
                        <select id="salutations" name="salutations" required class="form-control" style="width: 300px;">
                            <option value="" disabled selected hidden>Choose salutation</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Mdm.">Mdm.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Prof.">Prof.</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input required type="text" id="name" name="name" class="form-control" style="width: 500px;" placeholder="Enter name">
                        <img src="../img/Contact.png" alt="Image" class="img-fluid position-absolute top-20 end-0 translate-middle-y" style="height: 350px; width: 350px; margin-top: -195px; margin-left: 700px;">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input required maxlength="45" type="email" id="email" name="email" class="form-control" style="width: 500px;" placeholder="Enter email">
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message:</label>
                        <input required type="text" id="message" name="message" class="form-control" placeholder="Message" style="text-align: left; padding-bottom: 210px; height: 250px;">
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="contact" class="btn btn-primary" style="margin-top: 15px">Submit</button>
                    </div>
                </form>
<hr>
                <!-- About Us Container -->
                <div class="container mt-5">
                    <div class="row">
                        <div class="details col-md-6">
                            <h2>Contact Details</h2>
                            <p><i class="fas fa-envelope"></i> BookHub@gmail.com</p>
                            <p><i class="fas fa-map-marker-alt"></i> Company Address: Singapore Institute of Technology (SIT@NYP)</p>
                            <p><i class="fas fa-phone"></i> 172 Ang Mo Kio Ave 8, Singapore 567739</p>
                            <p><i class="fas fa-phone"></i> Call Us at: (+65) 6726 8488</p>
                        </div>
                        <div class="col-md-6">
                            <!-- Google Maps Location -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15954.661612111953!2d103.848787!3d1.3774334!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da16e96db0a1ab%3A0x3d0be54fbbd6e1cd!2sSingapore%20Institute%20of%20Technology%20(SIT%40NYP)!5e0!3m2!1sen!2ssg!4v1711699270111!5m2!1sen!2ssg" width="525" height="450" style="border:0;" allowfullscreen="" loading="eager" referrerpolicy="no-referrer-when-downgrade" title="Google Maps"></iframe>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
<br>
    <!-- Footer -->
    <?php
    include "inc/footer.inc.php";
    ?> 
</body>
</html>
