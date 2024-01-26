// contact form
const name = document.getElementById("input-contact-name");
const email = document.getElementById("input-email");
const submit = document.getElementById("submit-btn");

window.addEventListener('load', function() {
    setupListeners();
});

function setupListeners(){
    setupMouseListeners();
}

function validateForm(){
    return validateEmail() && validateName();
}

function validateName() {
    return name.value.length !== 0;
}

// validates email
function validateEmail() {
    let re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    return !!email.value.match(re);
}

function setupMouseListeners(){
    submit.addEventListener("mouseover", () => {
        submit.className += "-hover";

    });

    submit.addEventListener("mouseout", () => {
        submit.className = "submit-btn";

    });
}


/*
email.addEventListener("input", (Event) => {
    let invalidEmail = document.getElementById("contact-email-invalid");

    if (!validateEmail()) {
        invalidEmail.style.visibility = "visible";
    } else {
        invalidEmail.style.visibility = "hidden";
    }
});

// validates message
function validateMessage() {
    return !(message.value.length < MIN_MESSAGE || message.value.length > MAX_MESSAGE);
}

message.addEventListener("input", (Event) => {
    let invalidMessage = document.getElementById("contact-message-invalid");

    if(message.value.length < MIN_MESSAGE || message.value.length > MAX_MESSAGE) {
        invalidMessage.style.visibility = "visible";
    } else {
        invalidMessage.style.visibility = "hidden";
    }
});
*/
