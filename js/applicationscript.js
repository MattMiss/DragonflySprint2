// constants
const STATUS_VALUES = ["select", "need-to-apply", "applied", "interviewing", "rejected", "accepted", "inactive"];
const MAX_CHARACTERS = 60;
const MAX_URL = 500;

// elements
const jobName = document.getElementById("job-name");
const employer = document.getElementById("employer-name");
const jobURL = document.getElementById("job-url");
const appDate = document.getElementById("today");
const status = document.getElementById("application-status");
const followupDate = document.getElementById("two-weeks");

window.addEventListener('load', function() {
    setTodayDate();
    set2WeekDate();
});

function validateForm() {
    let isJobNameValid = validateJobName();
    let isEmployerValid = validateEmployer()
    let isURLValid = validateJobURL();
    let isAppDateValid = validateAppDate();
    let isFollowupValid = validateFollowupDate();
    let isStatusValid = validateStatus();

    let isValid = isJobNameValid && isEmployerValid && isURLValid && isAppDateValid && isFollowupValid && isStatusValid;

    return isValid;
}

function validateJobName() {
    let isValidLength = jobName.value.trim().length <= MAX_CHARACTERS;
    let isNotEmpty = jobName.value.trim().length > 0;
    let isValid = isValidLength && isNotEmpty;

    let jobNameError = document.getElementById("app-job-name-error");
    let message = `Please enter between 0 and ${MAX_CHARACTERS} characters`;
    let emptyMessage = "Please enter a job name";

    if(isValid === true) {
        jobName.classList.remove("form-input-error");
        jobNameError.style.visibility = "hidden";
    } else {
        if((isNotEmpty === false && isValidLength === false) || isValid === false) {
            jobNameError.innerText = message;
        } else if(isNotEmpty === false) {
            jobNameError.innerText = emptyMessage;
        }

        jobName.classList.add("form-input-error")
        jobNameError.style.visibility = "visible";
    }

    return isValid;
}

function validateEmployer() {
    let isValidLength = employer.value.trim().length <= MAX_CHARACTERS;
    let isNotEmpty = employer.value.trim().length > 0;
    let isValid = isValidLength && isNotEmpty;

    let employerError = document.getElementById("app-employer-error");
    let message = `Please enter between 0 and ${MAX_URL} characters`;
    let emptyMessage = "Please enter an employer";

    if(isValid === true) {
        employer.classList.remove("form-input-error");
        employerError.style.visibility = "hidden";
    } else {
        if((isNotEmpty === false && isValidLength === false) || isValid === false) {
            employerError.innerText = message;
        } else if(isNotEmpty === false) {
            employerError.innerText = emptyMessage;
        }

        employer.classList.add("form-input-error")
        employerError.style.visibility = "visible";
    }

    return isNotEmpty;
}

function validateJobURL() {
    let re = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/;
    let isValidLength = jobURL.value.length <= MAX_URL;
    let isValidFormat = re.test(jobURL.value);
    let isValid = isValidLength && isValidFormat;

    let urlError = document.getElementById("app-url-error");
    let message = `Please enter a valid URL less than ${MAX_URL} characters`;
    let formatMessage = "Please enter a valid URL";
    let lengthMessage = "Please enter a URL less than 500 characters";

    if(isValid === true) {
        jobURL.classList.remove("form-input-error");
        urlError.style.visibility = "hidden";
    } else {
        if(isValidFormat === false && isValidLength === false) {
            urlError.innerText = message;
        } else if(isValidFormat === false) {
            urlError.innerText = formatMessage;
        } else if(isValidLength === false) {
            urlError.innerText = lengthMessage;
        }

        jobURL.classList.add("form-input-error")
        urlError.style.visibility = "visible";
    }

    return isValidFormat;
}

function validateAppDate() {
    let isValid = appDate.value !== null;
    let appDateError = document.getElementById("app-date-error");

    if(isValid === false) {
        appDateError.innerText = "Please select a date";
        appDateError.style.visibility = "visible";
    } else {
        appDateError.style.visibility = "hidden";
    }

    return isValid;
}

function validateFollowupDate() {
    let isValid = followupDate.value !== null;
    let appDateError = document.getElementById("app-followup-error");

    if(isValid === false) {
        appDateError.innerText = "Please select a date";
        appDateError.style.visibility = "visible";
    } else {
        appDateError.style.visibility = "hidden";
    }

    return isValid;
}

function validateStatus() {
    let isValid = STATUS_VALUES.includes(status.value);

    const statusError = document.getElementById("app-status-error");

    if(isValid === false) {
        statusError.style.visibility = "visible";
    } else {
        statusError.style.visibility = "hidden";
    }

    return isValid;
}

function setTodayDate() {
    var today = new Date();
    var day = today.getDate();
    var month = today.getMonth()+1;
    var year = today.getFullYear();

    if(day<10) {
        day = '0'+day;
    }

    if(month<10) {
        month = '0'+month;
    }

    today = year + '-' + month + '-' + day;
    document.getElementById('today').value = today;
}
function set2WeekDate() {
    var twoWeekDay = new Date(Date.now() + 12096e5);
    var day = twoWeekDay.getDate();
    var month = twoWeekDay.getMonth()+1;
    var year = twoWeekDay.getFullYear();

    if(day<10) {
        day = '0'+day;
    }

    if(month<10) {
        month = '0'+month;
    }

    twoWeekDay = year + '-' + month + '-' + day;
    document.getElementById('two-weeks').value = twoWeekDay;
}

