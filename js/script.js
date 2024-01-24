const darkModeSwitch = document.getElementById("dark-mode-switch");

window.onload = function() {
    setupListeners();
}

function setupListeners(){
    setupDarkModeListener();
}

function setupDarkModeListener(){
    let darkModeOn = false;

    darkModeSwitch.addEventListener("change", () => {
        darkModeOn ? document.body.classList.remove('dark-mode') : document.body.classList.add('dark-mode');
        darkModeOn = !darkModeOn;
    });
}
