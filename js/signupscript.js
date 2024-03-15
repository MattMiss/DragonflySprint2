// sign up form
const firstName = document.getElementById("input-first-name");
const lastName = document.getElementById("input-last-name");
const email = document.getElementById("input-email");
const password = document.getElementById("input-password");
const passwordConfirm = document.getElementById("input-password-confirm");
const cohortNumber = document.getElementById("input-cohort-num");
const status = document.querySelectorAll("input[name='status']");
const roles = document.getElementById("input-roles");
const MIN_COHORT = 1;
const MAX_COHORT = 100;
const MIN_CHARACTERS = 0;
const MAX_CHARACTERS = 500;
const STATUS = ["Seeking Internship", "Seeking Job", "Not Actively Searching"];

function validateForm() {
    let isNameValid = validateName();
    let isEmailValid = validateEmail();
    let isPasswordValid = validatePassword();
    let isCohortNumValid = validateCohortNum();
    let isStatusValid = validateStatus();
    let isRolesValid = validateRoles();

    let isValid = isNameValid && isEmailValid && isPasswordValid && isCohortNumValid && isStatusValid && isRolesValid;

    return isValid;
}

// validates first and last name
function validateName() {
    let isFirstValid = firstName.value.length !== 0;
    let isLastValid = lastName.value.length !== 0;
    let isValid = isFirstValid === true && isLastValid === true;

    // selects message if it exists
    const nameError = document.getElementById("name-error");
    const nameMessage = "Please enter your first and last name";
    const firstNameMessage = "Please enter your first name";
    const lastNameMessage = "Please enter your last name";


    // decides which message to display (if any)
    if(isValid === true) {
        nameError.style.visibility = "hidden";
    } else {
        if(isFirstValid === false && isLastValid === false) {
            nameError.innerText = nameMessage;
        } else if(isFirstValid === false) {
            nameError.innerText = firstNameMessage;
        } else if(isLastValid === false) {
            nameError.innerText = lastNameMessage;
        }

        nameError.style.visibility = "visible";
    }

    return isValid;
}

// validates email
function validateEmail() {
    let re = /[^\s@]+@[^\s@]+\.[^\s@]+/;
    let isValid = re.test(email.value);

    const emailError = document.getElementById("email-error");

    if(isValid === false) {
        emailError.style.visibility = "visible";
    } else {
        emailError.style.visibility = "hidden";
    }

    return isValid;
}

// validates password
function validatePassword() {
    let re = /^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/;
    let isValid = re.test(password.value) && (password.value === passwordConfirm.value);
    const passwordError = document.getElementById("password-error");

    if(isValid === false) {
        passwordError.style.visibility = "visible";
    } else {
        passwordError.style.visibility = "hidden";
    }

    return isValid;
}

// validates cohort number
function validateCohortNum() {
    let isValid = (parseInt(cohortNumber.value) >= MIN_COHORT) && (parseInt(cohortNumber.value) <= MAX_COHORT);

    const cohortError = document.getElementById("cohort-error");

    if(isValid === false) {
        cohortError.style.visibility = "visible";
    } else {
        cohortError.style.visibility = "hidden";
    }

    return isValid;
}

// validate status
function validateStatus() {
    let isValid;
    let checked = 0;

    // checks that 1 button is checked
    for(const radioButton in status) {
        if(radioButton.checked === true) {
            isValid = STATUS.contains(radioButton.value) === true;
            checked++;
        }
    }

    isValid = isValid === true && checked === 1;
    const statusError = document.getElementById("status-error");

    if(isValid === false) {
        statusError.style.visibility = "visible";
    } else {
        statusError.style.visibility = "hidden";
    }

    return isValid;
}

// validates roles input
function validateRoles() {
    let isValid = (roles.value.length >= MIN_CHARACTERS) && (roles.value.length <= MAX_CHARACTERS);
    const rolesError = document.getElementById("roles-error");

    if(isValid === false) {
        rolesError.style.visibility = "visible";
    } else {
        rolesError.style.visibility = "hidden";
    }

    return isValid;
}

// event listeners
firstName.addEventListener("focusout", (Event) => {
    validateName();
});

lastName.addEventListener("focusout", (Event) => {
    validateName();
});

email.addEventListener("focusout", (Event) => {
    validateEmail();
});

password.addEventListener("focusout", (Event) => {
    validatePassword();
});

passwordConfirm.addEventListener("focusout", (Event) => {
    validatePassword();
});

cohortNumber.addEventListener("focusout", (Event) => {
    validateCohortNum();
});

roles.addEventListener("focusout", (Event) => {
    validateRoles();
});