// sign up form
const firstName = document.getElementById("edit-first-name");
const lastName = document.getElementById("edit-last-name");
const email = document.getElementById("edit-email");
const password = document.getElementById("input-password");
const passwordConfirm = document.getElementById("input-password-confirm");
const cohortNumber = document.getElementById("edit-cohort-num");
const status = document.querySelectorAll("input[name='status']");
const roles = document.getElementById("edit-roles");
const passwordList = document.getElementsByClassName('requirement');
const MIN_COHORT = 1;
const MAX_COHORT = 3000;
const MIN_CHARACTERS = 0;
const MAX_CHARACTERS = 500;
const STATUS = ["Seeking Internship", "Seeking Job", "Not Actively Searching"];
let validatePass = true;
const newPassDiv = $('#user-edit-new-pass');
const passReqsDiv = $('#user-edit-pass-reqs');

$(window).on('load', () => {
    validatePass = false;
   $('#user-edit-pass-select').on('change', (e) => {
       if (e.target.value === 'new'){
           newPassDiv.show()
           passReqsDiv.show()
           validatePass = true;
       }else if(e.target.value === 'same'){
           validatePass = false;
           newPassDiv.hide()
           passReqsDiv.hide()
       }
    })
    newPassDiv.hide();
    passReqsDiv.hide();
});

function validateForm() {
    let isNameValid = validateName();
    let isEmailValid = validateEmail();
    let isPasswordValid = (validatePass === false) || validatePassword();
    let isCohortNumValid = validateCohortNum();
    let isStatusValid = validateStatus();
    let isRolesValid = validateRoles();

    let isValid = isNameValid && isEmailValid && isPasswordValid && isCohortNumValid && isStatusValid && isRolesValid;

    if(isValid === false) {

        window.scroll({
            top: 70,
            left: 100,
            behavior: "smooth",
        });
    }

    return isValid;
}

// validates first and last name
function validateName() {
    let isFirstValid = firstName.value.trim().length !== 0;
    let isLastValid = lastName.value.trim().length !== 0;
    let isValid = isFirstValid === true && isLastValid === true;

    // selects message if it exists
    const nameError = document.getElementById("edit-name-error");
    const nameMessage = "Please enter your first and last name";
    const firstNameMessage = "Please enter your first name";
    const lastNameMessage = "Please enter your last name";


    // decides which message to display (if any)
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
    let re = /[^\s@]+@[^\s@]+\.[^\s@]+/;
    let isValid = re.test(email.value.trim());

    const emailError = document.getElementById("edit-email-error");

    if(isValid === true) {
        emailError.style.visibility = "hidden";
        email.setAttribute("class", "form-control");
    } else {
        emailError.style.visibility = "visible";
        email.setAttribute("class", "form-control form-input-error");
    }

    return isValid;
}

// validates password
function validatePassword() {
    let re = /^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/;
    let isValid = re.test(password.value.trim()) && (password.value.trim() === passwordConfirm.value.trim());
    const passwordError = document.getElementById("edit-password-error");

    if(isValid === false) {
        passwordError.style.visibility = "visible";
        password.classList.add('form-input-error');
        passwordConfirm.classList.add('form-input-error');
    } else {
        passwordError.style.visibility = "hidden";
        password.classList.remove('form-input-error');
        passwordConfirm.classList.remove('form-input-error');
    }

    return isValid;
}

// validates cohort number
function validateCohortNum() {
    let isValid = (parseInt(cohortNumber.value) >= MIN_COHORT) && (parseInt(cohortNumber.value) <= MAX_COHORT);

    const cohortError = document.getElementById("edit-cohort-error");

    if(isValid === false) {
        cohortError.style.visibility = "visible";
        cohortNumber.classList.add('form-input-error');
    } else {
        cohortError.style.visibility = "hidden";
        cohortNumber.classList.remove('form-input-error');
    }

    return isValid;
}

// validate status
function validateStatus() {
    let isValid = true;
    let isValidStatus = false;
    let checked = 0;

    const notSearching = document.getElementById("notSearching");
    const seekingJob = document.getElementById("seekingJob");
    const seekingInternship = document.getElementById("seekingInternship");

    if(notSearching.checked === true) {
        checked++;

        if(STATUS.includes(notSearching.value)) {
            isValidStatus = true;
        } else {
            isValidStatus = false;
            return isValidStatus;
        }
    }

    if(seekingJob.checked === true) {
        checked++;

        if(STATUS.includes(seekingJob.value)) {
            isValidStatus = true;
        } else {
            isValidStatus = false;
            return isValidStatus;
        }
    }

    if(seekingInternship.checked === true) {
        checked++;

        if(STATUS.includes(seekingInternship.value)) {
            isValidStatus = true;
        } else {
            isValidStatus = false;
            return isValidStatus;
        }
    }

    isValid = isValidStatus === true && checked === 1;
    const statusError = document.getElementById("edit-status-error");

    if(isValid === false) {
        statusError.style.visibility = "visible";
    } else {
        statusError.style.visibility = "hidden";
    }

    return isValid;
}

// validates roles input
function validateRoles() {
    console.log(roles.value.trim().length);
    let isValid = (roles.value.trim().length >= MIN_CHARACTERS) && (roles.value.trim().length <= MAX_CHARACTERS);
    const rolesError = document.getElementById("edit-roles-error");

    if(isValid === false) {
        rolesError.style.visibility = "visible";
    } else {
        rolesError.style.visibility = "hidden";
    }

    return isValid;
}

// event listeners

password.addEventListener("input", (Event) => {
    const numberExp = /\d/;
    let hasNumber = numberExp.test(password.value);

    let isLength = password.value.length >= 8 && password.value.length <= 16;
    let areMatching = (password.value === passwordConfirm.value) && (password.value.length > 0);

    console.log('here');
    if(hasNumber === true) {
        passwordList[1].classList.remove("fa-circle-xmark");
        passwordList[1].classList.add("fa-circle-check");
        passwordList[1].style.color = "#6cb443";
    } else {
        passwordList[1].classList.remove("fa-circle-check");
        passwordList[1].classList.add("fa-circle-xmark");
        passwordList[1].style.color = "#D14900";
    }

    if (isLength === true) {
        passwordList[0].classList.remove("fa-circle-xmark");
        passwordList[0].classList.add("fa-circle-check");
        passwordList[0].style.color = "#6cb443";
    } else {
        passwordList[0].classList.remove("fa-circle-check");
        passwordList[0].classList.add("fa-circle-xmark");
        passwordList[0].style.color = "#D14900";
    }

    if (areMatching === true) {
        passwordList[2].classList.remove("fa-circle-xmark");
        passwordList[2].classList.add("fa-circle-check");
        passwordList[2].style.color = "#6cb443";
    } else {
        passwordList[2].classList.remove("fa-circle-check");
        passwordList[2].classList.add("fa-circle-xmark");
        passwordList[2].style.color = "#D14900";
    }

});

passwordConfirm.addEventListener("input", (Event) => {
    let areMatching = (password.value === passwordConfirm.value) && (password.value.length > 0);

    if (areMatching === true) {
        passwordList[2].classList.remove("fa-circle-xmark");
        passwordList[2].classList.add("fa-circle-check");
        passwordList[2].style.color = "#6cb443";
    } else {
        passwordList[2].classList.remove("fa-circle-check");
        passwordList[2].classList.add("fa-circle-xmark");
        passwordList[2].style.color = "#D14900";
    }
});