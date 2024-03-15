/*
let darkModeSwitch;


window.addEventListener('load', function() {
    //console.log("Window loaded");
    console.log(document.cookie);

    // Setup Dark Mode using Cookies
    setupCookieDarkMode();

    // Setup Dark Mode using localStorage
    //setupLSDarkMode();
});



function setupCookieDarkMode(){
    darkModeSwitch = document.getElementById("dark-mode-switch");
    if (!darkModeSwitch) return;
    darkModeSwitch.addEventListener("change", () => {
        theme === 'light' ? setCookieDarkMode('dark') : setCookieDarkMode('light');
    });

    if (theme !== null){
        setCookieDarkMode(theme);
        darkModeSwitch.checked = theme === 'dark';
    }else
    {
        setCookieItem('theme', 'light');
    }


}

function setCookieDarkMode(newTheme){
    //console.log("Changed to : " + newTheme);
    document.documentElement.setAttribute('data-theme', newTheme);
    setCookieItem('theme', newTheme);
    theme = newTheme;
}

// Sets the cookie item at the max value (400 days). If user visits website within the 400 days, the cookie
// expiration will be extended by another 400 days and the user preferences will persist
// If user waits longer than 400 days, the cookie will be set back to default or null
function setCookieItem(key, value){
    const dt = new Date();
    dt.setTime(dt.getTime() + (400 * 24 * 60 * 60 * 1000));
    let expires = "expires=" + dt.toString();
    document.cookie = key + "=" + value + ";" + expires + ";path=/";
    console.log(document.cookie);
}

/*
function setupLSDarkMode(){
    darkModeSwitch = document.getElementById("dark-mode-switch");
    if (theme !== null){
        setLSDarkMode(theme);
        darkModeSwitch.checked = theme === 'dark';
    }else
    {
        setLocalStorageItem('theme', 'light');
    }

    darkModeSwitch.addEventListener("change", () => {
        theme === 'light' ? setLSDarkMode('dark') : setLSDarkMode('light');
    });
}

function setLSDarkMode(newTheme){
    //console.log("Changed to : " + newTheme);
    document.documentElement.setAttribute('data-theme', newTheme);
    setLocalStorageItem('theme', newTheme);
    theme = newTheme;
}

function setLocalStorageItem(key, value){
    localStorage.setItem(key, value);
}
*/