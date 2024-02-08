// sign up form
const name = document.getElementById("input-name");
const email = document.getElementById("input-email");
const cohortNumber = document.getElementById("input-cohort-num");
const roles = document.getElementById("input-roles");
const MIN = 1;
const MAX = 100;
const MIN_CHARACTERS = 50;
const MAX_CHARACTERS = 500;

function validateForm(){
    return validateName() && validateEmail() && validateCohortNum() && validateRoles();
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

// validates cohort number
function validateCohortNum() {
    return !(cohortNumber.value < MIN || cohortNumber.value > MAX);
}

// validates roles input
function validateRoles() {
    return !(roles.value.length < MIN_CHARACTERS || roles.value.length > MAX_CHARACTERS);
}