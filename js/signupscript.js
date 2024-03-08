// sign up form
const firstName = document.getElementById("input-first-name");
const lastName = document.getElementById("input-first-name");
const email = document.getElementById("input-email");
const password = document.getElementById("input-password");
const passwordConfirm = document.getElementById("input-password-confirm");
const cohortNumber = document.getElementById("input-cohort-num");
const roles = document.getElementById("input-roles");
const MIN_COHORT = 1;
const MAX_COHORT = 100;
const MIN_CHARACTERS = 5;
const MAX_CHARACTERS = 500;

function validateForm() {
    // alert("validateForm()");
    let isValid = validateName() && validateEmail() && validatePassword() && validateCohortNum() && validateRoles();

    return isValid;
}

// validates first and last name
function validateName() {
    // alert("validateName()");
    let isValid = (firstName.value.length !== 0) && (lastName.value.length !== 0);

    return isValid;
}

// validates email
function validateEmail() {
    // alert("validateEmail()");
    let re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    return re.test(email.value);
}

// validates password
function validatePassword() {
    let re = /^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/;
    let isValid = re.test(password.value) && (password.value === passwordConfirm.value);

    return isValid;
}

// validates cohort number
function validateCohortNum() {
    let isValid = (parseInt(cohortNumber.value) >= MIN_COHORT) && (parseInt(cohortNumber.value) <= MAX_COHORT);

    return isValid;
}

// validates roles input
function validateRoles() {
    let isValid = (roles.value.length >= MIN_CHARACTERS) && (roles.value.length <= MAX_CHARACTERS);

    return isValid;
}