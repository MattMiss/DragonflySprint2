let sortedApps = apps;
let tempApps;
let targetStatus = 'any';
let searchTerm = '';
let startDate = '';
let endDate = '';
let dateOrder = 0;
let jobOrder = 0;
let employerOrder = 0;
let statusOrder = 0;
let lastFieldClicked = ['', ''];
let appShowingCnt = 0;
let appCntToLoad = 0;
const APP_MAX_LOAD_CNT = 10;
const appListDiv = $('#dash-apps-list');

$(window).on('load', () => {
    setSearchEventListeners();
    setOrderBtnListeners();
    appCntToLoad = APP_MAX_LOAD_CNT;
    sortAppsByUserFilters();
    populateAppList();
});

function deleteAppBtnClicked(appID, appEmployer){
    //console.log("AppID: " + appID + " , Employer: " + appEmployer);
    const modalText = $('#modalText')[0];
    modalText.innerHTML = ('Delete application from ' + appEmployer + '?');

    const dltBtn = document.getElementById('deleteAppBtn');

    const dltHandler = () => {
        console.log("Deleting App: " + 'app-' + appID);
        const app = $('#app-' + appID);
        if (app){
            app.remove();
            modalText.innerHTML = "";
            showAlert('Application deleted!', 'danger');
            dltBtn.removeEventListener('click', dltHandler, false);
        }
    }
    dltBtn.addEventListener('click', dltHandler, false)
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

    // Set default order to date ascending
    toggleFieldOrder($('#date-up-btn'), $('#date-down-btn'), 'adate');
}


// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateAppList(){
    //console.log("App Cnt to Load: " + appCntToLoad);
    if (sortedApps.length === 0){
        appListDiv.append("<tr class='app-list-item' id='app-$id'>\n" +
            '                <td></td>\n' +
            '                <td></td>\n' +
            '                <td>No Results</td>\n' +
            '                <td></td>\n' +
            '                <td></td>\n' +
            "            </tr>");
    }

    for(let i = 0; i < sortedApps.length; i++){
        //console.log("AppShowingCnt: " + appShowingCnt);
        //console.log("AppCntToLoad: " + appCntToLoad);
        if (sortedApps[i].length === 0){continue} // don't show item if it's empty. for some reason the array has an empty item in it

        if (i+1 === sortedApps.length) $('#more-apps').hide();

        if (appShowingCnt === appCntToLoad) return;

        // Create Table Row
        const tRow = $(document.createElement('tr'));
        tRow.addClass('app-list-item');
        tRow.attr('id', 'app-' + sortedApps[i].application_id);
        appListDiv.append(tRow);
        // Create Table Data for App Date, Job Title, and Employer Name
        tRow.append('<td>' + sortedApps[i].adate + '</td>');
        tRow.append('<td>' + sortedApps[i].jname + '</td>');
        tRow.append('<td>' + sortedApps[i].ename + '</td>');
        // Create Table Data for the Status
        const statusOuter = $(document.createElement('td'));
        statusOuter.addClass('status status-'+sortedApps[i].astatus);
        statusOuter.append('<i class=\'fa-solid fa-circle\'></i>');
        statusOuter.append('<span style=\'text-transform: capitalize\'>'+sortedApps[i].astatus+'</span>');
        tRow.append((statusOuter));
        // Create Table Data for the App Button Outer
        const appBtnOuter = $(document.createElement('td'));
        appBtnOuter.addClass('app-button-outer');
        // Create a form to POST on submit (update button submits)
        const form = $(document.createElement('form'));
        form.attr('method', 'post');
        form.attr('action', 'application_edit.php');
        // Create hidden input
        const input = $(document.createElement('input'));
        input.attr('type', 'hidden');
        input.attr('name', 'application-id');
        input.val(sortedApps[i].application_id);
        form.append(input);
        // Create Edit Button (submits to POST onclick)
        const editBtn = $(document.createElement('button'));
        editBtn.attr('type', 'submit');
        editBtn.addClass('app-button-inner btn btn-sm btn-update');
        editBtn.append('<i class=\'fa-solid fa-pen\'></i>');
        form.append((editBtn));
        appBtnOuter.append((form));
        // Create Delete Button
        const deleteBtn = $(document.createElement('button'));
        deleteBtn.addClass('app-button-inner btn btn-sm btn-delete');
        deleteBtn.attr('data-bs-toggle', 'modal');
        deleteBtn.attr('data-bs-target', '#confirmModal');
        deleteBtn.click(() => deleteAppBtnClicked(sortedApps[i].application_id, sortedApps[i].ename));
        deleteBtn.append('<i class=\'fa-solid fa-trash\'></i>');

        appBtnOuter.append((deleteBtn));
        tRow.append(appBtnOuter);

        appShowingCnt++;
    }

    /*
    appListDiv.append("<tr class='app-list-item' id="+ app.application_id +">\n" +
        '                <td>' + app.adate + '</td>\n' +
        '                <td>' + app.jname + '</td>\n' +
        '                <td>' + app.ename + '</td>\n' +
        '                <td class=\'status status-'+app.astatus+'\'><i class=\'fa-solid fa-circle\'></i><span style=\'text-transform: capitalize\'>'+app.astatus+'</span></td>\n' +
        '                <td class=\'app-button-outer\'>\n' +
        '                    <form method=\'post\' action=\'application_edit.php\'>\n' +
        '                        <input type=\'hidden\' name=\'application-id\' value='+app.application_id+'>\n' +
        '                        <button type=\'submit\' class=\'app-button-inner btn btn-sm btn-update\'><i class=\'fa-solid fa-pen\'></i></button>\n' +
        '                     </form>\n' +
        '                    <button class=\'app-button-inner btn btn-sm btn-delete\' data-bs-toggle=\'modal\' data-bs-target=\'#confirmModal\' onclick=\'deleteAppBtnClicked('+app.application_id+')\'><i class=\'fa-solid fa-trash\'></i></button>\n' +
        '                </td>\n' +
        "            </tr>")

     */
}

// Remove children from application list
function emptyAppList(){
    appListDiv.empty();
    appShowingCnt = 0;
}

// Searches through all apps and adds apps that pass the filters into sortedApps
// sortedApps will be ordered by how the apps are ordered in the database
function sortAppsByUserFilters(){
    //startingAppIndex = 0;
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
            }
        }
    })
    sortedApps = tempApps;
}

// Cycle through buttons depending on the field clicked Each field has 3 states.
// [0 = no order, shows up and down arrows][1 = asc order, shows up arrow][2 = dsc order, shows down arrow]
function toggleFieldOrder(fieldBtnUp, fieldBtnDown, field){
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
            if(dateOrder === 3) dateOrder = 1;
            fieldIndex = dateOrder;
            break;
        case 'jname':
            jobOrder++;
            dateOrder = 0;
            employerOrder = 0;
            statusOrder = 0;
            if(jobOrder === 3) jobOrder = 1;
            fieldIndex = jobOrder;
            break;
        case 'ename':
            employerOrder++;
            dateOrder = 0;
            jobOrder = 0;
            statusOrder = 0;
            if(employerOrder === 3) employerOrder = 1;
            fieldIndex = employerOrder;
            break;
        case 'astatus':
            statusOrder++;
            dateOrder = 0;
            jobOrder = 0;
            employerOrder = 0;
            if(statusOrder === 3) statusOrder = 1;
            fieldIndex = statusOrder;
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
        if (a[field] < b[field] ){
            return direction === 'asc' ? -1 : 1;
        }
        if (a[field]  > b[field] ){
            return direction === 'dsc' ? -1 : 1;
        }
        return 0;
    });
}

// Load more apps by increasing the app count to load by APP_MAX_LOAD_CNT and then refresh the list
function loadMoreApps(){
    appCntToLoad += APP_MAX_LOAD_CNT;
    emptyAppList();
    populateAppList();
}
