const status = document.getElementById("application-status")
const submit = document.getElementById("submit-btn");
window.addEventListener('load', function() {
    setTodayDate();
    set2WeekDate();
    setupListeners();
});

function validateForm() {
    let selection = status.options[status.selectedIndex].value;
    var tinyText = document.getElementById("application-wrong")
    if(selection === "select") {
        tinyText.innerHTML = "Please select an option."
        status.focus();
        return false;
    }
}
function setupListeners(){
    setupMouseListeners();
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

function setupMouseListeners(){
    submit.addEventListener("mouseover", () => {
        submit.className += "-hover";

    });

    submit.addEventListener("mouseout", () => {
        submit.className = "submit-btn";

    });
}
