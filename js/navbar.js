const dateFormatChanged = new Event("dateFormatChanged");
let darkModeSwitch;
let dateFormatSelect = $('#date-format-select');
let blackLogo = $('#grc-logo');
let whiteLogo = $('#grc-logo-white');

$(window).on('load', () => {
    // Setup Dark Mode using Cookies
    setupCookieDarkMode();

    // Setup Dark Mode using localStorage
    //setupLSDarkMode();

    // Setup Date OnSelect
    setupFormatSelect();
});

function setupFormatSelect(){
    if (dateFormatSelect){
        dateFormatSelect.on('change', (e)=> {
            setDateFormat(e.target.value);
            setupDateFormat();
            // Let any attached listeners know the date format has changed
            document.dispatchEvent(dateFormatChanged);
        })
    }
}

function setDateFormat(format){
    switch(format){
        case 'mm-dd-yy':
            setCookieItem('date-format-' + uID, 'mm-dd-yy');
            break;
        case 'dd-mm-yy':
            setCookieItem('date-format-' + uID, 'dd-mm-yy');
            break;
        case 'yy-mm-dd':
            setCookieItem('date-format-' + uID, 'yy-mm-dd');
            break;
    }
}

function setupCookieDarkMode(){
    darkModeSwitch = $('#dark-mode-switch');

    if (!darkModeSwitch) return;
    darkModeSwitch.on('change', () => {
        theme === 'light' ? setCookieDarkMode('dark') : setCookieDarkMode('light');
    });

    if (theme !== null){
        setCookieDarkMode(theme);
        darkModeSwitch.checked = theme === 'dark';
    }else
    {
        setCookieItem('theme', 'light');
        setLogoTheme('light');
    }


}

function setCookieDarkMode(newTheme){
    $(document.documentElement).attr('data-theme', newTheme);
    setCookieItem('theme', newTheme);
    theme = newTheme;
    setLogoTheme(theme);
}

// Sets the cookie item at the max value (400 days). If user visits website within the 400 days, the cookie
// expiration will be extended by another 400 days and the user preferences will persist
// If user waits longer than 400 days, the cookie will be set back to default or null
function setCookieItem(key, value){
    const dt = new Date();
    dt.setTime(dt.getTime() + (400 * 24 * 60 * 60 * 1000));
    let expires = "expires=" + dt.toString();
    document.cookie = key + "=" + value + ";" + expires + ";path=/";
}

function setLogoTheme(theme){
    if (theme === 'dark'){
        whiteLogo.show();
        blackLogo.hide();
    }else if (theme === 'light'){
        whiteLogo.hide();
        blackLogo.show();
    }
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