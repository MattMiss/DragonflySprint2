const ADMIN = 1;
let viewRole = results.role;
let dateFormat = 'yy-mm-dd';

$(window).on('load', () => {
    // Check if there is a date format saved in cookies
    setupDateFormat();
    if (dateFormatSelect){
        dateFormatSelect.val(dateFormat);
    }
});

// Returns the viewRole set by server
function isAdmin(){
    return viewRole === ADMIN;
}

function setupDateFormat(){
    // Get cookies string and separate items by ';'
    const cookies = document.cookie.split('; ');
    // Set default theme to light
    dateFormat = 'mm-dd-yy';
    // Check cookies for a previously set theme value
    for(let i =0; i < cookies.length; i++){
        const name = cookies[i].split('=')[0];
        const value = cookies[i].split('=')[1];
        // Set the theme if one exists
        if (name === 'date-format-' + uID){
            dateFormat = value;
        }
    }
}

// Shows a div with a message at the top of the screen. Removes the div after supplied timeout time
function showToast(message, length) {
    const toastContainer = $('#toastContainer');

    toastContainer.addClass('alert-show');
    toastContainer.removeClass('alert-hide');
    $('#toastText').text(message);
    setTimeout(() => {
        toastContainer.removeClass('alert-show');
        toastContainer.addClass('alert-hide');
    }, length)
}

// Sort a provided list depending on which field is chosen
function sortListByField(targetList, direction, field){
    targetList.sort((a,b) => {
        if (a[field].toLowerCase() < b[field].toLowerCase() ){
            return direction === 'asc' ? -1 : 1;
        }
        if (a[field].toLowerCase()  > b[field].toLowerCase() ){
            return direction === 'dsc' ? -1 : 1;
        }
        return 0;
    });
}

// Fix need-to-apply status by removing dashes and replacing them
function getFormattedStatus(status){
    return status.replace(/-/g, " ");
}

function getFormattedURL(url){
    // Fix the URL to make it clickable
    let clickableUrl = url;
    if (!clickableUrl.startsWith("http")) {
        if (!clickableUrl.startsWith("www.")) {
            clickableUrl = `https://www.${url}`;
        } else {
            clickableUrl = `https://${url}`;
        }
    }
    return clickableUrl;
}

function getFormattedDate(date, format){
    const parts = date.split('-');
    let dateString = '';

    switch(format){
        case 'dd-mm-yy':
            dateString = parts[2] + '-' + parts[1] + '-' + parts[0][2] + parts[0][3];
            break;
        case 'yy-mm-dd':
            dateString = parts[0][2] + parts[0][3] + '-' + parts[1] + '-' +parts[2];
            break;
        case 'mm-dd-yy':
            dateString = parts[1] + '-' + parts[2] + '-' + parts[0][2] + parts[0][3];
            break;
    }
    return dateString;
}