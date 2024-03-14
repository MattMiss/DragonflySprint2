let sortedUsers = users;
let tempUsers;
let userStatus = 'any';
let userSearchTerm = '';
let userFieldButtonState = {
    "fname" : 0,
    "email" : 0,
    "status" : 0
}
let lastUserFieldClicked = null;
let showDeletedUsers = false;
const userListDiv = $('#dash-users-list');

$(window).on('load', () => {

    console.log(userID);
    // If admin is logged in, Setup Users Input change listeners and show the users
    if (isAdmin()){

        // Setup User Input change listeners
        setUserSearchListeners();
        setUserFieldBtnListeners();

        toggleUserFieldOrder('#user-name-field-icon', 'fname');
    }

    if (userWasDeleted) {
        showToast("User was deleted!", 2000);
    }
});

// Set up listeners for User Filter SearchTerm, User Status, and WHetehr user is Deleted or not
// List will reload if any User Filters are changed
function setUserSearchListeners(){
    // User List Listeners
    $('#users-search-bar').on('change keyup', (e) => {
        userSearchTerm = e.target.value;
        emptySortAndPopulateUsersList(false);
    });

    $('#user-status-select').on('change', (e) => {
        userStatus = e.target.value;
        emptySortAndPopulateUsersList(false);
    })

    $('#user-deleted-check').on('change', (e) => {
        showDeletedUsers = e.target.checked;
        toggleShowDeletedIcon();
        emptySortAndPopulateUsersList(false);
    })
}

// Onclick Events for OrderBy buttons on each field
// Clicking on a field button will cycle between ascending and descending
function setUserFieldBtnListeners(){
    $('#user-name-order-btn').on('click', () => {
        toggleUserFieldOrder('#user-name-field-icon', 'fname');
    });

    $('#user-email-order-btn').on('click', () => {
        toggleUserFieldOrder('#user-email-field-icon', 'email');
    });

    $('#user-status-order-btn').on('click', () => {
        toggleUserFieldOrder('#user-status-field-icon', 'status');
    });
    $('#user-role-order-btn').on('click', () => {
        toggleUserFieldOrder('#user-role-field-icon', 'permission');
    })
}

// Cycle through buttons depending on the field clicked Each field has 3 states.
// [0 = no order, shows up and down arrows][1 = asc order, shows up arrow][2 = dsc order, shows down arrow]
function toggleUserFieldOrder(clickedFieldIconName, clickedField){
    //console.log("Toggling Field order: " + clickedField);
    // If field is different from last field, reset last field (show both up and down arrows)
    //console.log("Last Field Click: " + lastAppFieldClicked);

    // Show Field Buttons for previously clicked field buttons but only if field button is not null or the
    // same as the previously clicked button
    if (lastUserFieldClicked && (lastUserFieldClicked !== clickedFieldIconName)){
        // Show the icon for up angle icon and down angle icon
        $(lastUserFieldClicked).removeClass().addClass('fa-solid fa-sort');
        userFieldButtonState[clickedField] = 0;
    }
    lastUserFieldClicked = clickedFieldIconName;

    // Initiate the fieldIndex that will eventually be set to the correct state index (0, 1, or 2)
    let selectedFieldIndex = 0;

    // Cycle field state index 0 through 2. 0 = No order, 1 = Ascending, 2 = Descending
    // Set fields except clickedField back to state 0 (No Order) by looping through
    // appFieldButtonState keys to find the clicked field by key
    Object.entries(userFieldButtonState).forEach((field) => {
        const [key, value] = field;

        if (key === clickedField){
            // Increase clickedField state by 1
            userFieldButtonState[key]++;
            // Cycle back n forth between 1(Asc) and 2(Desc)
            if (userFieldButtonState[key] === 3) userFieldButtonState[key] = 1;
            // Set selectedField index to the correct state index
            selectedFieldIndex = userFieldButtonState[key];
        }
    });
    // Empty the app-list, Sort by clickedField, then populate the app-list
    emptySortAndPopulateUsersList(true, selectedFieldIndex, clickedFieldIconName, clickedField);
}

// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateUsersList(){
    if (sortedUsers.length === 0){
        const noResults = '<tr class="user-list-item">\n' +
            '<td></td>\n' +
            '<td class="text-center">No Users</td>\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '</tr>';
        userListDiv.append(noResults);
    }

    for(let i = 0; i < sortedUsers.length; i++){
        createUserFromData(sortedUsers[i]);
    }
}

// Remove children from application list
function emptyUsersList(){
    userListDiv.empty();
}

// Searches through all users and adds users that pass the filters into sortedUsers
// sortedUsers will be ordered by how the users are ordered in the database
function sortUsersByFilters(){
    //console.log(users);
    tempUsers = [];
    users.forEach(singleUser => {
        // Return if app has no data
        if (singleUser.length === 0) return;
        // Only show items that match the dropdown status or if the "any" status is selected
        if (userStatus === 'any' || userStatus === singleUser.status){
            console.log(singleUser.is_deleted);
            if (!showDeletedUsers && singleUser.is_deleted === '1'){
                return;
            }
            // Show all on an empty search
            if (userSearchTerm === ''){
                tempUsers.push(singleUser);
            }

                // Show app if the user first or last name matches input or
                // If the user email matches input
            // If the status matches input
            else if (singleUser.fname.toLowerCase().includes(userSearchTerm.toLowerCase()) ||
                singleUser.lname.toLowerCase().includes(userSearchTerm.toLowerCase()) ||
                singleUser.email.toLowerCase().includes(userSearchTerm.toLowerCase())){
                tempUsers.push(singleUser);
            }
        }
    })
    sortedUsers = tempUsers;
    //console.log(sortedUsers);
}

// Create a user list item using the supplied userData
function createUserFromData(userData) {

    /*
    $(editBtn).on('click', () => {
        showAppModal(appData, statusReplace, clickableUrl);
    })
     */
    const deletedUser = userData.is_deleted === "1";
    const itemClass = "user-list-item" + (deletedUser ? " deleted-user" : "");
    const deletedIcon = deletedUser ? '<i class="fa-solid fa-user-slash deleted-user-icon"></i>' : "";

    const role = userData.permission === '0' ? 'User' : 'Admin';

    // Create a list item with the application data filled in
    const user =
        $(`<tr class="${itemClass}" id="user-${userData.user_id}">\n` +
            `<td>${role}</td>\n` +
            `<td>${deletedIcon}${userData.fname} ${userData.lname}</td>\n` +
            `<td>${userData.email}</td>\n` +
            `<td>${userData.status}</td>\n` +
            `</td>\n` +
            `</tr>`);

    /*
    user.on('click', () => {
        //TODO: show user info
    })
     */

    const isUserAdmin = userData.permission === '1';

    // Create an edit button and add an onclick listener to Open User Modal when edit button is clicked
    const makeAdminBtn = $(`<button class="app-button-inner btn btn-make-admin">${isUserAdmin ? 'Remove' : 'Make'} Admin</button>`);
    if (userID == userData.user_id){
        makeAdminBtn.attr('disabled', true);
    }
    makeAdminBtn.on('click', () => {
        if (isUserAdmin){
            askToRemoveAdmin(userData.user_id, userData.fname, userData.lname);
        }else{
            askToMakeUserAdmin(userData.user_id, userData.fname, userData.lname);
        }
    })

    // Create an edit button and add an onclick listener to Open User Modal when edit button is clicked
    const editBtn = $(`<button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>`);
    editBtn.on('click', () => {
        showUserModal(userData, isUserAdmin);
    })

    // Create a delete button and add an onclick listener to ask to Delete App when delete button is clicked
    const deleteBtn = $(`<button class="app-button-inner btn btn-sm btn-delete"><i class="fa-solid fa-trash"></i>`);
    deleteBtn.on('click', () => {
        askToDeleteUser(userData.user_id, userData.fname, userData.lname);
    })

    // Show edit and delete btn div is viewRole is a USER and nothing is viewRole is ADMIN
    const btnDiv = $('<td class="app-button-outer"></td>');
    btnDiv.append(makeAdminBtn);
    btnDiv.append(editBtn);
    btnDiv.append(deleteBtn);
    // Add button div to app
    user.append(btnDiv);
    userListDiv.append(user);


    /*---------------------  TESTING A DROPDOWN MENU HERE -------------------------------------
    const isUserAdmin = userData.permission === '1';

    // Create an edit button and add an onclick listener to Open User Modal when edit button is clicked
    const makeAdminBtn = $(`<button class="admin-btn dropdown-item"><i class="fa-solid fa-user-tie pe-2"></i>${isUserAdmin ? 'Remove' : 'Make'} Admin</button>`);
    if (userID == userData.user_id){
        makeAdminBtn.attr('disabled', true);
    }
    makeAdminBtn.on('click', () => {
        if (isUserAdmin){
            askToRemoveAdmin(userData.user_id, userData.fname, userData.lname);
        }else{
            askToMakeUserAdmin(userData.user_id, userData.fname, userData.lname);
        }
    })

    // Create an edit button and add an onclick listener to Open User Modal when edit button is clicked
    const editBtn = $(`<li><button class="dropdown-item" href="#"><i class="fa-solid fa-pen pe-2"></i>Edit User</button></li>`);
    editBtn.on('click', () => {
        showUserModal(userData, isUserAdmin);
    })

    // Create a delete button and add an onclick listener to ask to Delete App when delete button is clicked
    const deleteBtn = $(`<li><button class="dropdown-item" href="#"><i class="fa-solid fa-trash pe-2"></i>Delete User</button></li>`);
    deleteBtn.on('click', () => {
        askToDeleteUser(userData.user_id, userData.fname, userData.lname);
    })

    // Show edit and delete btn div is viewRole is a USER and nothing is viewRole is ADMIN
    const btnDiv = $('<td class="app-button-outer "></td>');
    btnDiv.append(makeAdminBtn);
    btnDiv.append(editBtn);
    btnDiv.append(deleteBtn);
    // Add button div to app
    //user.append(btnDiv);

    const tableDropdownDiv = $('<td class="text-end"></td>');
    const dropdownDiv = $('<div class="dropstart user-dropdown"></div>');
    const dropdownBtn = $('<button class="user-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>');
    const dropdownMenu = $('<ul class="dropdown-menu"></ul>');
    tableDropdownDiv.append(dropdownDiv);
    dropdownDiv.append(dropdownBtn);
    dropdownDiv.append(dropdownMenu);
    dropdownMenu.append(makeAdminBtn);
    dropdownMenu.append(editBtn);
    dropdownMenu.append(deleteBtn);

    //console.log(user);
    user.append(tableDropdownDiv);
    userListDiv.append(user);
     */
}

// Empty the user-list, Sort by clickedField, then populate the user-list
// If sortBySpecificField is true, then sort users using the provided field type
function emptySortAndPopulateUsersList(sortBySpecificField = false, selectedFieldIndex, clickedFieldIconName, clickedField){
    // Empty out the user list
    emptyUsersList();
    // Sort users by the inputs
    sortUsersByFilters();
    // Sort by a specific field if true, otherwise skip this
    if (sortBySpecificField){
        switch (selectedFieldIndex){
            case 2:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort-down');
                sortListByField(sortedUsers, 'dsc', clickedField);
                break;
            case 1:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort-up');
                sortListByField(sortedUsers, 'asc', clickedField);
                break;
            case 0:
            default:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort');
                break;
        }
    }
    populateUsersList();
}

function showUserModal(userData, isUserAdmin) {
    //console.log(userData);
    // Open user edit modal
    $('#user-edit-modal').modal('show');

    // Fill in user information
    $('#user-edit-modal-fname').text(userData.fname);
    $('#user-edit-modal-lname').text(userData.lname);
    $('#user-edit-modal-email').text(userData.email);
    $('#user-edit-modal-password').text("****************");
    $('#user-edit-modal-cohort').text(userData.cohortNum);
    $('#user-edit-modal-job-status').text(userData.status);
    $('#user-edit-modal-roles').text(userData.roles);

    // Fill in hidden ID
    $('#edit-modal-user-id').val(userData.user_id);

    // Fill in deleted or not value
    if (userData.is_deleted == 0) {
        $('#user-edit-modal-deleted').text("Not Deleted");
    } else {
        $('#user-edit-modal-deleted').text("Deleted");
    }

    // Fill in admin or user values
    if (isUserAdmin === true) {
        $('#user-edit-modal-permission').text("Admin");
        $('#user-edit-modal-admin').text("Remove Admin");
    } else {
        $('#user-edit-modal-permission').text("User");
        $('#user-edit-modal-admin').text("Make Admin");
    }

    $('#user-edit-modal-admin').on('click', () => {
        if (isUserAdmin) {
            askToRemoveAdmin(userData.user_id, userData.fname, userData.lname);
        } else {
            askToMakeUserAdmin(userData.user_id, userData.fname, userData.lname);
        }
    })

    // Self check, cannot remove admin from self
    if (userID == userData.user_id){
        $('#user-edit-modal-admin').attr('disabled', true);
    } else {
        $('#user-edit-modal-admin').attr('disabled', false);
    }
}

// Open delete user modal and set the value for user id to delete
function askToDeleteUser(userID, userFName, userLName){
    // Open the user delete modal
    $('#user-delete-modal').modal('show');

    $('#user-delete-modal-name').text(`${userFName} ${userLName}`)

    // Set the value of the hidden input for delete-user-id
    // THis will be sent to POST as the userID to delete
    $('#delete-user-id').val(userID);
}

// Open make user admin modal and fill in user info
function askToMakeUserAdmin(userID, userFName, userLName){
    // Open the user delete modal
    $('#toggle-admin-modal').modal('show');

    $('#toggle-admin-title').text('Make Admin?');
    $('#toggle-admin-btn').html('Make Admin');
    $('#toggle-admin-modal-name').text(`Give Admin Permission to ${userFName} ${userLName}?`)

    // Set the value of the hidden input for delete-user-id
    // THis will be sent to POST as the userID to delete
    $('#toggle-admin-user-id').val(userID);
    $('#toggle-admin-user-perm').val(1);
}

// Open make user admin modal and fill in user info
function askToRemoveAdmin(userID, userFName, userLName){
    // Open the user delete modal
    $('#toggle-admin-modal').modal('show');

    $('#toggle-admin-title').text('Remove Admin?');
    $('#toggle-admin-btn').text('Remove Admin');
    $('#toggle-admin-modal-name').text(`Remove Admin Permission from ${userFName} ${userLName}?`)

    // Set the value of the hidden input for delete-user-id
    // THis will be sent to POST as the userID to delete
    $('#toggle-admin-user-id').val(userID);
    $('#toggle-admin-user-perm').val(0);
}

// Toggle the eye and eye-slash icon on and off
function toggleShowDeletedIcon(){
    $('#show-deleted-users-btn').html('Deleted Users ' +(showDeletedUsers ? `<i class="fa-regular fa-eye"></i>` :
        `<i class="fa-regular fa-eye-slash"></i>`));
}


