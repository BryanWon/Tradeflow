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
                            <p><i class="fas fa-envelope"></i> Lorem Ipsum</p>
                            <p><i class="fas fa-address-book"></i> Tradeflow Capital Management</p>
                            <p><i class="fas fa-map-marker-alt"></i> 10 Marina Blvd, #08-05 TradeFlow Capital Management Pte Ltd, MBFC Tower 2, Singapore 018983</p>
                            <p><i class="fas fa-phone"></i> Call Us at: (+65) 6726 8488</p>
                        </div>
                        <div class="col-md-6">
                            <!-- Google Maps Location -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15955.293981865108!2d103.8541591!3d1.2795092!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80798a5e124e0743%3A0xf29bb9f079f7aba4!2sTradeflow%20Capital%20Management%20Pte%20Ltd!5e0!3m2!1sen!2ssg!4v1719460302377!5m2!1sen!2ssg" width="550" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                        </div>
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
