let darkModeSwitch;
let footerJobsSection;
let footerResourcesSection;

window.addEventListener('load', function() {
    //console.log("Window loaded");
    setupDarkMode();
});

function setupDarkMode(){
    darkModeSwitch = document.getElementById("dark-mode-switch");
    if (theme !== null){
        setDarkMode(theme);
        darkModeSwitch.checked = theme === 'dark';
    }else
    {
        localStorage.setItem('theme','light');
    }

    darkModeSwitch.addEventListener("change", () => {
        theme === 'light' ? setDarkMode('dark') : setDarkMode('light');
    });
}

function setDarkMode(newTheme){
    //console.log("Changed to : " + newTheme);
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    theme = newTheme;
}
