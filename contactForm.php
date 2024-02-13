<?php
    session_start();
    $_SESSION['header-title'] = 'Contact Form';
    include 'header.php'?>
    <main>
        <div class="container p-3" id="main-container">
            <h3 class="form-header">Contact</h3>
            <div class="form-container">
                <div class="form-body">
                    <form method="post" action="contactPHP.php" onsubmit="return validateForm()" name="contact" class="my-3">
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


<!--<div class="form-error">-->
<!--    <h3>Message failed to send. Please try again.</h3>-->
<!--    <a class='link' href='contactForm.html'>Return to contact form</a>-->
<!--</div>-->

<?php include 'footer.php' ?>
<script src="js/contactscript.js"></script>
</body>
</html>