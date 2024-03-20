// constants
const MIN_MESSAGE = 25;
const MAX_MESSAGE = 1000;

// elements
const firstName = document.getElementById("contact-first-name");
const lastName = document.getElementById("contact-last-name")
const email = document.getElementById("contact-email");
const message = document.getElementById("contact-message");

// calls all validate functions
function validateForm() {
    let isNameValid = validateName();
    let isEmailValid = validateEmail();
    let isMessageValid = validateMessage();

    let isValid = isNameValid && isEmailValid && isMessageValid;

    return isValid;
}

// validates first and last name
function validateName() {
    // removes whitespaces and checks length
    let isFirstValid = firstName.value.trim().length !== 0;
    let isLastValid = lastName.value.length.trim().length !== 0;
    let isValid = isFirstValid === true && isLastValid === true;

    // gets error message
    const nameError = document.getElementById("contact-name-error");
    const nameMessage = "Please enter your first and last name";
    const firstNameMessage = "Please enter your first name";
    const lastNameMessage = "Please enter your last name";


    // decides which message to display (if any), adds form-input-error class
    if(isValid === true) {
        nameError.style.visibility = "hidden";
        firstName.classList.remove("form-input-error");
        lastName.classList.remove("form-input-error");
    } else {
        if(isFirstValid === false && isLastValid === false) {
            nameError.innerText = nameMessage;
            firstName.classList.add("form-input-error");
            lastName.classList.add("form-input-error");
        } else if(isFirstValid === false) {
            nameError.innerText = firstNameMessage;
            firstName.classList.add("form-input-error");
            lastName.classList.remove("form-input-error");
        } else if(isLastValid === false) {
            nameError.innerText = lastNameMessage;
            lastName.classList.add("form-input-error");
            firstName.classList.remove("form-input-error");
        }

        nameError.style.visibility = "visible";
    }

    return isValid;
}

// validates email
function validateEmail() {
    // tests email against a regular expression
    let re = /[^\s@]+@[^\s@]+\.[^\s@]+/;
    let isValid = re.test(email.value);

    const emailError = document.getElementById("contact-email-error");

    // displays message, adds form-input-error class
    if(isValid === false) {
        emailError.style.visibility = "visible";
        email.classList.add("form-input-error");
    } else {
        emailError.style.visibility = "hidden";
        email.classList.remove("form-input-error");
    }

    return isValid;
}

// validates message
function validateMessage() {
    // removes whitespaces and checks length
    let isValid = (message.value.trim().length >= MIN_MESSAGE) && (message.value.trim().length <= MAX_MESSAGE);

    let messageError = document.getElementById("contact-message-error");

    // displays message, adds form-input-error class
    if(isValid === false) {
        messageError.style.visibility = "visible";
        message.classList.add("form-input-error");
    } else {
        messageError.style.visibility = "hidden";
        message.classList.remove("form-input-error");
    }

    return isValid;
}


