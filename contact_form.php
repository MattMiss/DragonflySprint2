<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Load theme from localstorage -->
    <script src="js/themescript.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css"/>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php
    session_start();
    $_SESSION['header-title'] = 'ATT - Contact Form';
include 'php/nav_bar.php' ?>
    <main>
        <div class="container p-3" id="main-container">
            <h3 class="form-header">Contact</h3>
            <div class="form-container">
                <div class="form-body">
                    <form method="post" action="php/contact_submit.php" onsubmit="return validateForm()" name="contact" class="my-3">
                        <label for="name" class="form-label">Name*</label>
                        <div id="name" class="row mb-4">
                            <div class="col-sm">
                                <input type="text" class="form-control" name="firstName" placeholder="First name" aria-label="First name" required>
                            </div>
                            <div class="col-sm pt-sm-0 pt-2">
                                <input type="text" class="form-control" name="lastName" placeholder="Last name" aria-label="Last name" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="input-email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="input-email" name="email" placeholder="e.g. example@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="input-message" class="form-label">Message*</label>
                            <textarea class="form-control" id="input-message" name="message" placeholder="Type your message here..." rows="4" minlength="25" maxlength="1000" required></textarea>
                        </div>


                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php include 'php/footer.php' ?>
<!-- Special Javascript to allow special contact things work -->
<script src="js/contactscript.js"></script>
<script src="js/main.js"></script>
</body>
</html>