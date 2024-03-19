let sortedAllAnnouncements = results.allAnnouncements;
let sortedMyAnnouncements = results.myAnnouncements;
let tempAllAnnouncements;
let announceJobType = 'both';
let announceSearchTerm = '';
let announceStartDate = '';
let announceEndDate = '';
let announceFieldButtonState = {
    "date_created" : 0,
    "title" : 0,
    "ename" : 0,
    "job_type" : 0,
}
let lastAnnounceFieldClicked = null;
let curAnnounceListDirection = '';
let curAnnounceListField = '';
const announceListDiv = $('#dash-announcements-list');
const myAnnouncementsDiv = $('#my-announcements');


$(window).on('load', () => {
    document.addEventListener('dateFormatChanged', (e)=>{
        if (isAdmin()){
            emptyAnnouncementList()
            populateAnnouncementList();
        }else{
            emptyMyRemindersList();
            populateMyRemindersList();
        }
    }, true)

    // Setup Admin Announcement Input change Listeners
    if (isAdmin()){
        setAnnounceSearchListeners();
        setAnnounceFieldBtnListeners();

        // Toggle Date twice to set default order to date ascending
        toggleAnnounceFieldOrder('#announce-date-field-icon', 'date_created');
        toggleAnnounceFieldOrder('#announce-date-field-icon', 'date_created');
    }

    emptyMyRemindersList();
    populateMyRemindersList();

    if (results.announceWasDeleted){
        showToast("Announcement was deleted!", 2000, '#e54a4a');
    }
});

// Set up listeners for Announcement Filter StartDate, EndDate, SearchTerm, and Job Type
// List will reload if any Filters are changed
function setAnnounceSearchListeners(){
    // App List Listeners
    $('#announce-search-bar').on('change keyup', (e) => {
        announceSearchTerm = e.target.value;
        emptySortAndPopulateAnnounceList(false);
    });

    $('#announce-job-type-select').on('change', (e) => {
        announceJobType = e.target.value;
        emptySortAndPopulateAnnounceList(false);
    });

    $('#announce-start-date').on('change', (e) => {
        announceStartDate = e.target.value;
        emptySortAndPopulateAnnounceList(false);
    });

    $('#announce-end-date').on('change', (e) => {
        announceEndDate = e.target.value;
        emptySortAndPopulateAnnounceList(false);
    });
}

// Onclick Events for OrderBy buttons on each field
// Clicking on a field button will cycle between ascending and descending
function setAnnounceFieldBtnListeners(){
    $('#announce-date-order-btn').on('click', () => {
        toggleAnnounceFieldOrder('#announce-date-field-icon', 'date_created');
    });

    $('#announce-title-order-btn').on('click', () => {
        toggleAnnounceFieldOrder('#announce-title-field-icon', 'title');
    });

    $('#announce-job-type-order-btn').on('click', () => {
        toggleAnnounceFieldOrder('#announce-job-type-field-icon', 'job_type');
    });

    $('#announce-employer-order-btn').on('click', () => {
        toggleAnnounceFieldOrder('#announce-employer-field-icon', 'ename');
    });

}

// Cycle through buttons depending on the field clicked Each field has 3 states.
// [0 = no order, shows up and down arrows][1 = asc order, shows up arrow][2 = dsc order, shows down arrow]
function toggleAnnounceFieldOrder(clickedFieldIconName, clickedField){
    // Show Field Buttons for previously clicked field buttons but only if field button is not null or the
    // same as the previously clicked button
    if (lastAnnounceFieldClicked && (lastAnnounceFieldClicked !== clickedFieldIconName)){
        // Show the icon for up angle icon and down angle icon
        $(lastAnnounceFieldClicked).removeClass().addClass('fa-solid fa-sort');
        announceFieldButtonState[clickedField] = 0;
    }
    lastAnnounceFieldClicked = clickedFieldIconName;

    // Initiate the fieldIndex that will eventually be set to the correct state index (0, 1, or 2)
    let selectedFieldIndex = 0;

    // Cycle field state index 0 through 2. 0 = No order, 1 = Ascending, 2 = Descending
    // Set fields except clickedField back to state 0 (No Order) by looping through
    // appFieldButtonState keys to find the clicked field by key
    Object.entries(announceFieldButtonState).forEach((field) => {
        const [key, value] = field;

        if (key === clickedField){
            // Increase clickedField state by 1
            announceFieldButtonState[key]++;
            // Cycle back n forth between 1(Asc) and 2(Desc)
            if (announceFieldButtonState[key] === 3) announceFieldButtonState[key] = 1;
            // Set selectedField index to the correct state index
            selectedFieldIndex = announceFieldButtonState[key];
        }
    });
    // Empty the app-list, Sort by clickedField, then populate the app-list
    emptySortAndPopulateAnnounceList(true, selectedFieldIndex, clickedFieldIconName, clickedField);
}

function emptyAnnouncementList(){
    announceListDiv.empty();
}

function emptyMyRemindersList(){
    myAnnouncementsDiv.empty();
}

// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateAnnouncementList(){
    if (sortedAllAnnouncements.length === 0){
        const noResults = '<tr class="user-list-item">\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '<td class="text-center">No Announcements</td>\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '</tr>';
        announceListDiv.append(noResults);
    }else{
        sortedAllAnnouncements.forEach((announcement) => {
            createAnnounceFromData(announcement);
        })
    }
}

function populateMyRemindersList(){
    if (sortedMyAnnouncements.length === 1 && sortedMyAnnouncements[0].length === 0){
        const noResults =   `<div class="reminder">
                                            <p>No Recent Announcements</p>
                                        </div>`;
        myAnnouncementsDiv.append(noResults);
    }else{
        sortedMyAnnouncements.forEach((announcement) => {
            createMyAnnounceFromData(announcement);
        })
    }
}

function createAnnounceFromData(announceData){
    const announceDate = getFormattedDate(announceData.date_created, dateFormat);
    const jobType = announceData.job_type.charAt(0).toUpperCase() + announceData.job_type.slice(1);

    // Create a list item with the application data filled in
    const announce =
        $(`<tr class="announce-list-item">\n` +
            `<td class="table-date">${announceDate}</td>\n` +
            `<td class="table-title">${announceData.title}</td>\n` +
            `<td class="table-employer">${announceData.ename}</td>\n` +
            `<td class="table-job-type">${jobType}</td>\n` +
            `<td class='table-link job-url'><a href=${announceData.jurl} target='_blank'>Apply Now</a></td>\n` +
            `</tr>`);

    // Create a delete button and add an onclick listener to ask to Delete App when delete button is clicked
    const deleteBtn = $(`<button class="app-button-inner btn btn-sm btn-delete"><i class="fa-solid fa-trash"></i>`);
    deleteBtn.on('click', () => {
        askToDeleteAnnouncement(announceData);
    })

    // Show edit and delete btn div is viewRole is a USER and nothing is viewRole is ADMIN
    const btnDiv = $('<td class="app-button-outer table-btns"></td>');
    btnDiv.append(deleteBtn);
    // Add button div to app
    announce.append(btnDiv);

    announceListDiv.append(announce);
}

// Searches through all announcements and adds announcements that pass the filters into sortedAllAnnouncements
// sortedAllAnnouncements will be ordered by how the announcements are ordered in the database
function sortAnnouncementsByUserFilters(){
    tempAllAnnouncements = [];
    results.allAnnouncements[0].forEach(singleAnnouncement => {
        // Return if announcement has no data
        if (singleAnnouncement.length === 0) return;

        // Only show items that match the dropdown job_type or if the "both" job_type is selected
        if (announceJobType === 'both' || singleAnnouncement.job_type === announceJobType){
            const createdDate = new Date(singleAnnouncement.date_created);
            // Return if there is a startDate chosen and it's before the date created
            if (announceStartDate !== '' && createdDate < new Date(announceStartDate)){
                return;
            }
            // Return if there is an endDate chosen and it's after the date created
            if (announceEndDate !== '' && createdDate > new Date(announceEndDate)){
                return;
            }

            // Show all on an empty search
            if (announceSearchTerm === ''){
                tempAllAnnouncements.push(singleAnnouncement);
            }
            // Show announcement if the employer name matches input or
            // If the job title matches input or
            // If the job type matches input
            else if (singleAnnouncement.title.toLowerCase().includes(announceSearchTerm.toLowerCase()) ||
                singleAnnouncement.ename.toLowerCase().includes(announceSearchTerm.toLowerCase()) ||
                singleAnnouncement.job_type.toLowerCase().includes(announceSearchTerm.toLowerCase())){
                tempAllAnnouncements.push(singleAnnouncement);
            }
        }
    })
    sortedAllAnnouncements = tempAllAnnouncements;
}

// Empty the announcement-list, Sort by clickedField, then populate the announcement-list
// If newFieldWasClicked is true, then sort announcements using the provided field type
function emptySortAndPopulateAnnounceList(newFieldWasClicked = false, selectedFieldIndex, clickedFieldIconName, clickedField){
    // Empty out the announcements list
    emptyAnnouncementList();
    // Sort announcements by the inputs
    sortAnnouncementsByUserFilters();
    // Sort by a specific field if true, otherwise skip this
    if (newFieldWasClicked){
        curAnnounceListField = clickedField;
        switch (selectedFieldIndex){
            case 2:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort-down');
                curAnnounceListDirection = 'dsc';
                sortListByField(sortedAllAnnouncements, curAnnounceListDirection, curAnnounceListField);
                break;
            case 1:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort-up');
                curAnnounceListDirection = 'asc';
                sortListByField(sortedAllAnnouncements, curAnnounceListDirection, curAnnounceListField);
                break;
            case 0:
            default:
                $(clickedFieldIconName).removeClass().addClass('fa-solid fa-sort');
                break;
        }
    }else{
        sortListByField(sortedAllAnnouncements, curAnnounceListDirection, curAnnounceListField);
    }
    populateAnnouncementList();
}

function createMyAnnounceFromData(announceData){
    const announceDate = getFormattedDate(announceData.date_created, dateFormat);

    // Create a list item with the application data filled in
    const announce =
        $(`<div class='reminder'>
                    <i class='fa-regular fa-comment'></i>
                    <button class='announcement-modal-btn text-start' type='button' onclick='showViewAnnouncementModal(${JSON.stringify(announceData)})' >${announceData.title} ${announceData.job_type} at <span>${announceData.ename}</span></button>
                    <p>Date Created: <span>${announceDate}</span></p>
                </div>`);

    myAnnouncementsDiv.append(announce);
}

function showViewAnnouncementModal(announcement){
    // Open view announcement modal
    $('#view-announcement-modal').modal('show');

    $('#view-announce-title').text(announcement.title);
    $('#view-announce-employer').text(announcement.ename);
    $('#view-announce-address').text(announcement.location);
    $('#view-announce-jurl').attr('href', announcement.jurl);
    $('#view-announce-info').text(announcement.additional_info);
}

function askToDeleteAnnouncement(announcement){
    // Open delete annoucnement Modal
    $('#delete-announcement-modal').modal('show');

    $('#delete-announce-title').text(announcement.title);
    $('#delete-announcement-id').val(announcement.announcement_id);
}

