// contact form
const MIN_MESSAGE = 25;
const MAX_MESSAGE = 1000;
const firstName = document.getElementsByName("firstName");
const lastName = document.getElementsByName("lastName");
const email = document.getElementById("input-email");
const message = document.getElementById("input-message");
// const submit = document.getElementById("submit-btn");

// window.addEventListener('load', function() {
//     setupListeners();
// });
//
// function setupListeners(){
//     //setupMouseListeners();
// }

function validateForm(){
    return validateEmail() && validateName() && validateMessage();
}

// validates first and last name
function validateName() {
    return firstName.value.length !== 0 && lastName.value.length !== 0;
}

// validates email
function validateEmail() {
    let re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    return !!email.value.match(re);
}

// validates message
function validateMessage() {
    return !(message.value.length < MIN_MESSAGE || message.value.length > MAX_MESSAGE);
}

// function setupMouseListeners(){
//     submit.addEventListener("mouseover", () => {
//         submit.className += "-hover";
//
//     });
//
//     submit.addEventListener("mouseout", () => {
//         submit.className = "submit-btn";
//
//     });
// }


/*
email.addEventListener("input", (Event) => {
    let invalidEmail = document.getElementById("contact-email-invalid");

    if (!validateEmail()) {
        invalidEmail.style.visibility = "visible";
    } else {
        invalidEmail.style.visibility = "hidden";
    }
});
*/

// message.addEventListener("input", (Event) => {
//     let invalidMessage = document.getElementById("contact-message-invalid");
//
//     if(message.value.length < MIN_MESSAGE || message.value.length > MAX_MESSAGE) {
//         invalidMessage.style.visibility = "visible";
//     } else {
//         invalidMessage.style.visibility = "hidden";
//     }
// });

