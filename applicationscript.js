const darkModeSwitch = document.getElementById("dark-mode-switch");
const submit = document.getElementById("submit-btn");

window.onload = function() {
    setTodayDate();
    set2WeekDate();
    setupListeners();
}

function setupListeners(){
    setupMouseListeners();
    setupDarkModeListener();
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

function setupDarkModeListener() {
    let darkModeOn = false;

    darkModeSwitch.addEventListener("change", () => {
        darkModeOn ? document.body.classList.remove('dark-mode') : document.body.classList.add('dark-mode');
        darkModeOn = !darkModeOn;
    });
}

function setupMouseListeners(){
    submit.addEventListener("mouseover", (Event) => {
        submit.className += "-hover";

    });

    submit.addEventListener("mouseout", (Event) => {
        submit.className = "submit-btn";

    });
}
