let sortedApps = apps;
let tempApps;
let targetStatus = 'any';
let searchTerm = '';
let startDate = '';
let endDate = '';
let appFieldButtonState = {
    "adate" : 0,
    "jname" : 0,
    "ename" : 0,
    "astatus" : 0,
    "fname" : 0,
    "email" : 0
}
let lastAppFieldClicked = null;
let appShowingCnt = 0;
const APP_MAX_LOAD_CNT = 10;
let appCntToLoad = APP_MAX_LOAD_CNT;
const appListDiv = $('#dash-apps-list');

$(window).on('load', () => {
    appCntToLoad = APP_MAX_LOAD_CNT;

    // Setup App Input change Listeners
    setAppSearchListeners();
    setAppFieldBtnListeners();

    // Toggle Date twice to set default order to date ascending
    toggleAppFieldOrder('#date-field-icon', 'adate');
    toggleAppFieldOrder('#date-field-icon', 'adate');

   if (appWasDeleted){
        showToast("Application was deleted!", 2000);
   }
});


// Set up listeners for User Filter StartDate, EndDate, SearchTerm, and Selected Status
// List will reload if any User Filters are changed
function setAppSearchListeners(){
    // App List Listeners
    $('#app-search-bar').on('change keyup', (e) => {
        searchTerm = e.target.value;
        emptySortAndPopulateAppList(false);
    });

    $('#app-status-select').on('change', (e) => {
        targetStatus = e.target.value;
        emptySortAndPopulateAppList(false);
    });

    $('#app-start-date').on('change', (e) => {
        startDate = e.target.value;
        emptySortAndPopulateAppList(false);
    });

    $('#app-end-date').on('change', (e) => {
        endDate = e.target.value;
        emptySortAndPopulateAppList(false);
    });
}

// Onclick Events for OrderBy buttons on each field
// Clicking on a field button will cycle between ascending and descending
function setAppFieldBtnListeners(){
    $('#date-order-btn').on('click', () => {
        toggleAppFieldOrder('#date-field-icon', 'adate');
    });

    $('#job-order-btn').on('click', () => {
        toggleAppFieldOrder('#job-field-icon', 'jname');
    });

    $('#employer-order-btn').on('click', () => {
        toggleAppFieldOrder('#employer-field-icon', 'ename');
    });

    $('#status-order-btn').on('click', () => {
        toggleAppFieldOrder('#status-field-icon', 'astatus');
    });

    // Set click listeners for user and email if role is admin
    if (isAdmin()){
        $('#user-order-btn').on('click', () => {
            toggleAppFieldOrder('#user-field-icon', 'fname');
        });
        $('#email-order-btn').on('click', () => {
            toggleAppFieldOrder('#email-field-icon', 'email');
        });
    }
}

// Cycle through buttons depending on the field clicked Each field has 3 states.
// [0 = no order, shows up and down arrows][1 = asc order, shows up arrow][2 = dsc order, shows down arrow]
function toggleAppFieldOrder(clickedFieldIconName, clickedField){
    //console.log("Toggling Field order: " + clickedField);
    // If field is different from last field, reset last field (show both up and down arrows)
    //console.log("Last Field Click: " + lastAppFieldClicked);

    // Show Field Buttons for previously clicked field buttons but only if field button is not null or the
    // same as the previously clicked button
    if (lastAppFieldClicked && (lastAppFieldClicked !== clickedFieldIconName)){
        // Show the icon for up angle icon and down angle icon
        $(lastAppFieldClicked).removeClass().addClass('fa-solid fa-sort');
        appFieldButtonState[clickedField] = 0;
    }
    lastAppFieldClicked = clickedFieldIconName;

    // Initiate the fieldIndex that will eventually be set to the correct state index (0, 1, or 2)
    let selectedFieldIndex = 0;

    // Cycle field state index 0 through 2. 0 = No order, 1 = Ascending, 2 = Descending
    // Set fields except clickedField back to state 0 (No Order) by looping through
    // appFieldButtonState keys to find the clicked field by key
    Object.entries(appFieldButtonState).forEach((field) => {
        const [key, value] = field;

        if (key === clickedField){
            // Increase clickedField state by 1
            appFieldButtonState[key]++;
            // Cycle back n forth between 1(Asc) and 2(Desc)
            if (appFieldButtonState[key] === 3) appFieldButtonState[key] = 1;
            // Set selectedField index to the correct state index
            selectedFieldIndex = appFieldButtonState[key];
        }
    });
    // Empty the app-list, Sort by clickedField, then populate the app-list
    emptySortAndPopulateAppList(true, selectedFieldIndex, clickedFieldIconName, clickedField);
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

// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateAppList(){

    // Clear the class on the btn header div and add a hidden class if the admin is viewing
    $('#dash-app-btn-header').removeClass().addClass('w-btn' + (isAdmin() ? ' hidden' : ''));

    let noResults;

    if (isAdmin()){
        noResults =
            '<tr class="app-list-item">\n' +
            '    <td></td>\n' +
            '    <td></td>\n' +
            '    <td></td>\n' +
            '    <td>No Results</td>\n' +
            '    <td></td>\n' +
            '    <td></td>\n' +
            '</tr>';
    }else{
        noResults =
            '<tr class="app-list-item">\n' +
            '    <td></td>\n' +
            '    <td></td>\n' +
            '    <td>No Results</td>\n' +
            '    <td></td>\n' +
            '    <td></td>\n' +
            '</tr>';
    }

    // Add Item that says "No Result" the app-list if there are no apps to show
    if (sortedApps.length === 0){
        appListDiv.append(noResults);
    }else{
        // Show the more button if there are still apps to show
        $('#more-apps').show();
    }

    for(let i = 0; i < sortedApps.length; i++){

        if (i === (sortedApps.length-1)) $('#more-apps').hide();    // Hide the "More" button if all apps are loaded
        if (appShowingCnt === appCntToLoad) return; // Stop creating app items if max app count has been reached

        createAppFromData(sortedApps[i]);
    }
}

// Remove children from application list
function emptyAppList(){
    appListDiv.empty();
    appShowingCnt = 0;
}

// Searches through all apps and adds apps that pass the filters into sortedApps
// sortedApps will be ordered by how the apps are ordered in the database
function sortAppsByUserFilters(){
    //console.log(apps);
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
            }else if(isAdmin()){   // Search terms for user and email which is only shown for admins

                if (singleApp.fname.toLowerCase().includes(searchTerm.toLowerCase()) ||
                    singleApp.lname.toLowerCase().includes(searchTerm.toLowerCase()) ||
                    singleApp.email.toLowerCase().includes(searchTerm.toLowerCase())){
                    tempApps.push(singleApp);
                }
            }
        }
    })
    sortedApps = tempApps;
    //console.log(sortedApps);
}

// Create an application list item using the supplied appData
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

    let app;

    if (isAdmin()){
        // Create a list item with the application data filled in for an ADMIN
        app = $(`<tr class="app-list-item" id="app-${appData.application_id}">\n` +
            `<td>${appData.adate}</td>\n` +
            `<td>${appData.jname}</td>\n` +
            `<td>${appData.ename}</td>\n` +
            `<td>${appData.jurl}</td>\n` +
            //`<td>${appData.fname} ${appData.lname}</td>\n` +
            //`<td>${appData.email}</td>\n` +
            //`<td class="status status-${appData.astatus}">\n` +
            //`    <i class="fa-solid fa-circle"></i>\n` +
            //`    <span style="text-transform: capitalize">` + statusReplace + `</span>\n` +
            //`</td>\n` +
            `</tr>`);
    }else{
        // Create a list item with the application data filled in for a USER
        app = $(`<tr class="app-list-item" id="app-${appData.application_id}">\n` +
            `<td>${appData.adate}</td>\n` +
            `<td>${appData.jname}</td>\n` +
            `<td>${appData.ename}</td>\n` +
            `<td class="status status-${appData.astatus}">\n` +
            `    <i class="fa-solid fa-circle"></i>\n` +
            `    <span style="text-transform: capitalize">` + statusReplace + `</span>\n` +
            `</td>\n` +
            `</tr>`);
        // Create an edit button and add an onclick listener to Open App Modal when edit button is clicked
        const editBtn = $(`<button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>`);
        editBtn.on('click', () => {
            showAppModal(appData, statusReplace, clickableUrl);
        })

        // Create a delete button and add an onclick listener to ask to Delete App when delete button is clicked
        const deleteBtn = $(`<button class="app-button-inner btn btn-sm btn-delete"><i class="fa-solid fa-trash"></i>`);
        deleteBtn.on('click', () => {
            askToDeleteApplication(appData.application_id, appData.ename);
        })

        // Show edit and delete btn div is viewRole is a USER and nothing is viewRole is ADMIN
        const btnDiv = $('<td class="app-button-outer"></td>');
        btnDiv.append(editBtn);
        btnDiv.append(deleteBtn);
        // Add button div to app
        app.append(btnDiv);
    }

    /* This was set so the view modal opened on app click, but it was getting called when delete button was clicked too
    // Set an onclick listener to open app modal
    app.on('click', ()=> {
        showAppModal(appData, statusReplace, clickableUrl);
    })
     */

    // Add app to the app-list and increase app showing count
    appListDiv.append(app);
    appShowingCnt++;
}

// Empty the app-list, Sort by clickedField, then populate the app-list
// If sortBySpecificField is true, then sort apps using the provided field type
function emptySortAndPopulateAppList(sortBySpecificField = false, selectedFieldIndex, clickedFieldIconName, clickedField){
    // Empty out the app list
    emptyAppList();
    // Sort apps by the inputs
    sortAppsByUserFilters();
    // Sort by a specific field if true, otherwise skip this
    if (sortBySpecificField){
        switch (selectedFieldIndex){
            case 2:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort-down');
                sortListByField(sortedApps,'dsc', clickedField);
                break;
            case 1:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort-up');
                sortListByField(sortedApps, 'asc', clickedField);
                break;
            case 0:
            default:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort');
                break;
        }
    }
    populateAppList();
}

// Load more apps by increasing the app count to load by APP_MAX_LOAD_CNT and then refresh the list
function loadMoreApps(){
    console.log("Loading more Apps");
    appCntToLoad += APP_MAX_LOAD_CNT;
    emptyAppList();
    populateAppList();
}

// Open the edit-modal and fill in the data from the appData
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

    // Also show the user name and email if an Admin is viewing the application
    if (isAdmin()){
        $('#edit-modal-user').text(appData.fname + " " + appData.lname);
        $('#edit-modal-email').text(appData.email);
    }
}

// Open the app-delete-modal and fill in the user ID
function askToDeleteApplication(appID, appEmployer){
    // TODO: Possibly show the appEmployer name on the delete modal so the user knows for sure which app was clicked
    $('#app-delete-modal').modal('show');

    $('#app-delete-modal-company').text(' ' + appEmployer);

    // Set the modal hidden input to the appID so POST can grab the ID from index.php on submit
    const deleteID = $('#delete-id');
    deleteID.val(appID);
}
