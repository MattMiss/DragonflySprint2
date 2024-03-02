let sortedApps = apps;
let viewRole = role;
let tempApps;
let targetStatus = 'any';
let searchTerm = '';
let startDate = '';
let endDate = '';
let dateOrder = 0;
let jobOrder = 0;
let employerOrder = 0;
let statusOrder = 0;
let userOrder = 0;
let emailOrder = 0;
let lastFieldClicked = ['', ''];
let appShowingCnt = 0;
const APP_MAX_LOAD_CNT = 10;
let appCntToLoad = APP_MAX_LOAD_CNT;
const appListDiv = $('#dash-apps-list');

$(window).on('load', () => {
    setSearchEventListeners();
    setOrderBtnListeners();
    appCntToLoad = APP_MAX_LOAD_CNT;
    //sortAppsByUserFilters();
    //populateAppList();
});

function deleteAppBtnClicked(appID, appEmployer){
    // Set the modal hidden input to the appID so POST can grab the ID from index.php on submit
    const deleteID = $('#delete-id');
    deleteID.val(appID);
}

function showAlert(message, type) {
    const alertPlaceholder = $('#alertPlaceholder');
    const wrapper = document.createElement('div');
    wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('');
    alertPlaceholder.append(wrapper);

    window.setTimeout(() => {
        wrapper.remove();
    }, 2000);
}

// Set up listeners for User Filter StartDate, EndDate, SearchTerm, and Selected Status
// List will reload if any User Filters are changed
function setSearchEventListeners(){
    $('#app-search-bar').on('change keyup', (e) => {
        searchTerm = e.target.value;
        console.log(e);
        emptyAppList();
        sortAppsByUserFilters();
        populateAppList();
    });

    $('#app-status-select').on('change', (e) => {
        targetStatus = e.target.value;
        emptyAppList();
        sortAppsByUserFilters();
        populateAppList();
    });

    $('#app-start-date').on('change', (e) => {
        startDate = e.target.value;
        emptyAppList();
        sortAppsByUserFilters();
        populateAppList();
    });

    $('#app-end-date').on('change', (e) => {
        endDate = e.target.value;
        emptyAppList();
        sortAppsByUserFilters();
        populateAppList();
    });

}

// Onclick Events for OrderBy buttons on each field
// Clicking on a field button will cycle between ascending and descending
function setOrderBtnListeners(){
    $('#date-order-btn').on('click', () => {
        toggleFieldOrder($('#date-up-btn'), $('#date-down-btn'), 'adate');
    });

    $('#job-order-btn').on('click', () => {
        toggleFieldOrder($('#job-up-btn'), $('#job-down-btn'), 'jname');
    });

    $('#employer-order-btn').on('click', () => {
        toggleFieldOrder($('#employer-up-btn'), $('#employer-down-btn'), 'ename');
    });

    $('#status-order-btn').on('click', () => {
        toggleFieldOrder($('#status-up-btn'), $('#status-down-btn'), 'astatus');
    });

    // Set click listeners for user and email if role is admin
    if (viewRole === 1){
        $('#user-order-btn').on('click', () => {
            toggleFieldOrder($('#user-up-btn'), $('#user-down-btn'), 'fname');
        });
        $('#email-order-btn').on('click', () => {
            toggleFieldOrder($('#email-up-btn'), $('#email-down-btn'), 'email');
        });
    }

    // Toggle Date twice to set default order to date ascending
    toggleFieldOrder($('#date-up-btn'), $('#date-down-btn'), 'adate');
    toggleFieldOrder($('#date-up-btn'), $('#date-down-btn'), 'adate');
}


// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateAppList(){
    // Clear the class on the btn header div and add a hidden class if the admin is viewing
    $('#dash-app-btn-header').removeClass().addClass('w-btn' + (viewRole === 1 ? ' hidden' : ''));

    if (sortedApps.length === 0){
        const noResults = '<tr class="app-list-item">\n' +
                                      '<td></td>\n' +
                                      '<td></td>\n' +
                                      '<td>No Results</td>\n' +
                                      '<td></td>\n' +
                                      '<td></td>\n' +
                                  '</tr>';
        appListDiv.append(noResults);
    }else{
        $('#more-apps').show();
    }

    for(let i = 0; i < sortedApps.length; i++){
        //if (appData.length === 0){continue} // don't show item if it's empty. for some reason the array has an empty item in it

        if (i === (sortedApps.length-1)) $('#more-apps').hide();    // Hide the "More" button if all apps are loaded
        if (appShowingCnt === appCntToLoad) return; // Stop creating app items if max app count has been reached

        createAppFromData(sortedApps[i]);
    }
}

function createAppFromData(appData){
    // Fix need-to-apply status by removing dashes and replacing them
    let statusReplace = `${appData.astatus}`;
    statusReplace = statusReplace.replace(/-/g, " ");

    // Fix the URL to make it clickable
    let clickableUrl = `${appData.jurl}`;
    if (!clickableUrl.startsWith("http")) {
        if (!clickableUrl.startsWith("www.")) {
            clickableUrl = `https://www.${appData.jurl}`;
        } else {
            clickableUrl = `https://${appData.jurl}`;
        }
    }

    // Only show userName if admin role is viewing
    // (username won't exist for a user role since they know their name already)
    const userName = (viewRole === 1) ? `<td>${appData.fname} ${appData.lname}</td>\n` : ``;
    const email = (viewRole === 1) ? `<td>${appData.email}</td>\n` : ``;

    const editBtn = `<button class="app-button-inner btn btn-sm btn-update">\n` +
                                `<i class="fa-solid fa-pen"></i>\n` +
                            `</button>`;

    $(editBtn).on('click', () => {
        showAppModal(appData, statusReplace, clickableUrl);
    })

    // Only show edit and delete btn for user
    const btnDiv = (viewRole === 0) ? `<td class="app-button-outer">\n` +
                                                 `${editBtn}\n` +
                                                `<button class="app-button-inner btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#delete-modal" +
                                                                                        onclick="() => deleteAppBtnClicked(${appData.application_id}, ${appData.ename})">\n` +
                                                    `<i class="fa-solid fa-trash"></i>\n` +
                                                `</button>\n` +
                                            `</td>\n` : '';

    // Create a list item with the application data filled in
    const app =
        $(`<tr class="app-list-item" id="app-${appData.application_id}">\n` +
            `<td>${appData.adate}</td>\n` +
            `<td>${appData.jname}</td>\n` +
            `<td>${appData.ename}</td>\n` +
            `${userName}` +
            `${email}` +
            `<td class="status status-${appData.astatus}">\n` +
                `<i class="fa-solid fa-circle"></i>\n` +
                `<span style="text-transform: capitalize">` + statusReplace + `</span>\n` +
            `</td>\n` +
            `${btnDiv}` +
        `</tr>`);

    app.on('click', ()=> {
        showAppModal(appData, statusReplace, clickableUrl);
    })

    appListDiv.append(app);
    appShowingCnt++;
}

// Remove children from application list
function emptyAppList(){
    appListDiv.empty();
    appShowingCnt = 0;
}

// Searches through all apps and adds apps that pass the filters into sortedApps
// sortedApps will be ordered by how the apps are ordered in the database
function sortAppsByUserFilters(){
    console.log(apps);
    tempApps = [];
    apps.forEach(singleApp => {
        // Return if app has no data
        if (singleApp.length === 0) return;

        // Only show items that match the dropdown status or if the "any" status is selected
        if (targetStatus === 'any' || singleApp.astatus === targetStatus){
            const appliedDate = new Date(singleApp.adate);
            // Return if there is a startDate chosen and it's before the applied date
            if (startDate !== '' && appliedDate < new Date(startDate)){
                return;
            }
            // Return if there is an endDate chosen and it's after the applied date
            if (endDate !== '' && appliedDate > new Date(endDate)){
                return;
            }

            // Show all on an empty search
            if (searchTerm === ''){
                tempApps.push(singleApp);
            }
            // Show app if the employer name matches input or
            // If the job name matches input or
            // If the status matches input
            else if (singleApp.ename.toLowerCase().includes(searchTerm.toLowerCase()) ||
                singleApp.jname.toLowerCase().includes(searchTerm.toLowerCase()) ||
                singleApp.astatus.toLowerCase().includes(searchTerm.toLowerCase())){
                tempApps.push(singleApp);
            }else if(viewRole === 1){   // Search terms for user and email which is only shown for admins

                if (singleApp.fname.toLowerCase().includes(searchTerm.toLowerCase()) ||
                    singleApp.lname.toLowerCase().includes(searchTerm.toLowerCase()) ||
                    singleApp.email.toLowerCase().includes(searchTerm.toLowerCase())){
                        tempApps.push(singleApp);
                }
            }
        }
    })
    sortedApps = tempApps;
    console.log(sortedApps);
}

// Cycle through buttons depending on the field clicked Each field has 3 states.
// [0 = no order, shows up and down arrows][1 = asc order, shows up arrow][2 = dsc order, shows down arrow]
function toggleFieldOrder(fieldBtnUp, fieldBtnDown, field){
    console.log("Toggling Field order: " + field);
    // If field is different from last field, reset last field (show both up and down arrows)
    console.log("Last Field Click: " + lastFieldClicked[0]);
    if (lastFieldClicked[0] !== '' && lastFieldClicked[0] !== fieldBtnUp){
        lastFieldClicked[0].show();
        lastFieldClicked[1].show();
    }
    // Cycle date order index 0 through 2
    let fieldIndex = 0;
    switch(field){
        case 'adate':
            dateOrder++;
            jobOrder = 0;
            employerOrder = 0;
            statusOrder = 0;
            userOrder = 0;
            emailOrder = 0;
            if(dateOrder === 3) dateOrder = 1;
            fieldIndex = dateOrder;
            break;
        case 'jname':
            jobOrder++;
            dateOrder = 0;
            employerOrder = 0;
            statusOrder = 0;
            userOrder = 0;
            emailOrder = 0;
            if(jobOrder === 3) jobOrder = 1;
            fieldIndex = jobOrder;
            break;
        case 'ename':
            employerOrder++;
            dateOrder = 0;
            jobOrder = 0;
            statusOrder = 0;
            userOrder = 0;
            emailOrder = 0;
            if(employerOrder === 3) employerOrder = 1;
            fieldIndex = employerOrder;
            break;
        case 'astatus':
            statusOrder++;
            dateOrder = 0;
            jobOrder = 0;
            employerOrder = 0;
            userOrder = 0;
            emailOrder = 0;
            if(statusOrder === 3) statusOrder = 1;
            fieldIndex = statusOrder;
            break;
        case 'fname':
            userOrder++;
            dateOrder = 0;
            jobOrder = 0;
            employerOrder = 0;
            statusOrder = 0;
            emailOrder = 0;
            if (userOrder === 3) userOrder = 1
            fieldIndex = userOrder;
            break;
        case 'email':
            emailOrder++;
            dateOrder = 0;
            jobOrder = 0;
            employerOrder = 0;
            statusOrder = 0;
            userOrder = 0;
            if (emailOrder === 3) emailOrder = 1
            fieldIndex = emailOrder;
            break;
    }

    emptyAppList();
    sortAppsByUserFilters();
    switch (fieldIndex){
        case 2:
            fieldBtnUp.hide();
            fieldBtnDown.show();
            sortByField('dsc', field);
            break;
        case 1:
            fieldBtnUp.show();
            fieldBtnDown.hide();
            sortByField('asc', field);
            break;
        case 0:
        default:
            fieldBtnUp.show();
            fieldBtnDown.show();
            break;
    }
    lastFieldClicked[0] = fieldBtnUp;
    lastFieldClicked[1] = fieldBtnDown;

    populateAppList();
}

// Sort a list of applications depending on which field is chosen
// Fields will be 'adate', 'jname', 'ename', 'astatus'
function sortByField(direction, field){
    //console.log("Direction: " + direction + ", Field: " + field);
    sortedApps.sort((a,b) => {
        if (a[field].toLowerCase() < b[field].toLowerCase() ){
            return direction === 'asc' ? -1 : 1;
        }
        if (a[field].toLowerCase()  > b[field].toLowerCase() ){
            return direction === 'dsc' ? -1 : 1;
        }
        return 0;
    });
}

// Load more apps by increasing the app count to load by APP_MAX_LOAD_CNT and then refresh the list
function loadMoreApps(){
    console.log("Loading more Apps");
    appCntToLoad += APP_MAX_LOAD_CNT;
    emptyAppList();
    populateAppList();
}


function showAppModal(appData, status, formattedUrl){
    console.log(appData.jname);

    $('#edit-modal').modal('show');

    // Fill in modal info
    $('#edit-modal-jname').text(appData.jname);
    $('#edit-modal-ename').text(appData.ename);
    $('#edit-modal-description').text(appData.jdescription)
    $('#edit-modal-astatus').text(status);
    $('#edit-modal-fdate').text(appData.followupdate);
    $('#edit-modal-updates').text(appData.fupdates);
    $('#edit-modal-appid').val(appData.application_id);

    const urlText = $('#edit-modal-url');
    urlText.attr('href', appData.jurl);
    urlText.text(formattedUrl);

    const statusIcon = $('#edit-modal-astatus-icon');
    statusIcon.removeClass();
    statusIcon.addClass('status status-' + appData.astatus);

    if (viewRole === 1){
        $('#edit-modal-user').text(appData.fname + " " + appData.lname);
        $('#edit-modal-email').text(appData.email);
    }
}