<?php
global $formLocation;

echo "
    <main>
        <div class='container p-3' id='main-container'>
            <div class='empty-form-msg pt-5 d-flex flex-column justify-content-center'>
                <h2 class='align-self-center'>Please fill out the form.</h2>
                <a class='link pt-3 align-self-center' href='$formLocation'>Go back</a>
            </div>
        </div>
    </main>
  ";
?>