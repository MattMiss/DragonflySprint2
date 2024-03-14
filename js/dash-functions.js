const ADMIN = 1;
let viewRole = role;

// Returns the viewRole set by server
function isAdmin(){
    return viewRole === ADMIN;
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