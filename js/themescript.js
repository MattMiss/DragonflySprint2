let theme;

initThemeWithCookies(); // Use Cookies to get/set theme
//initThemeWithLocalStorage();  // Use LocalStorage to get/set theme

function initThemeWithCookies(){
    // Get cookies string and separate items by ';'
    const cookies = document.cookie.split('; ');
    // Set default theme to light
    theme = 'light';
    // Check cookies for a previously set theme value
    for(let i =0; i < cookies.length; i++){
        const name = cookies[i].split('=')[0];
        const value = cookies[i].split('=')[1];
        // Set the theme if one exists
        if (name === 'theme'){
            theme = value;
        }
    }
    document.documentElement.setAttribute('data-theme', theme);
}


function initThemeWithLocalStorage(){
    theme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', theme);
}