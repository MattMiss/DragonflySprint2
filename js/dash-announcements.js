let sortedAllAnnouncements = results.allAnnouncements;
let sortedMyAnnouncements = results.myAnnouncements;
const announceListDiv = $('#dash-announcements-list');
const myAnnouncementsDiv = $('#my-announcements');


$(window).on('load', () => {
    document.addEventListener('dateFormatChanged', (e)=>{
        //console.log("Date Changed");
        emptyAnnouncementList()
        populateAnnouncementList();
    }, true)

    emptyAnnouncementList();
    populateAnnouncementList();

    if (results.announceWasDeleted){
        showToast("Announcement was deleted!", 2000);
    }
});

function emptyAnnouncementList(){
    if (isAdmin()){
        announceListDiv.empty();
    }else{
        myAnnouncementsDiv.empty();
    }

}

// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateAnnouncementList(){
    if (isAdmin()){
        if (sortedAllAnnouncements[0].length === 0){
            const noResults = '<tr class="user-list-item">\n' +
                '<td></td>\n' +
                '<td></td>\n' +
                '<td class="text-center">No Announcements</td>\n' +
                '<td></td>\n' +
                '<td></td>\n' +
                '</tr>';
            announceListDiv.append(noResults);
        }else{
            sortedAllAnnouncements[0].forEach((announcement) => {
                createAnnounceFromData(announcement);
            })
        }
    }else{
        if (sortedMyAnnouncements.length === 0){
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
}

function createAnnounceFromData(announceData){
    const announceDate = getFormattedDate(announceData.date_created, dateFormat);

    // Create a list item with the application data filled in
    const announce =
        $(`<tr>\n` +
            `<td>${announceDate}</td>\n` +
            `<td>${announceData.title} ${announceData.job_type}</td>\n` +
            `<td>${announceData.ename}</td>\n` +
            `<td class='job-url'><a href=${announceData.jurl} target='_blank'>Apply Now</a></td>\n` +
            `</tr>`);

    // Create a delete button and add an onclick listener to ask to Delete App when delete button is clicked
    const deleteBtn = $(`<button class="app-button-inner btn btn-sm btn-delete"><i class="fa-solid fa-trash"></i>`);
    deleteBtn.on('click', () => {
        askToDeleteAnnouncement(announceData);
    })

    // Show edit and delete btn div is viewRole is a USER and nothing is viewRole is ADMIN
    const btnDiv = $('<td class="app-button-outer"></td>');
    btnDiv.append(deleteBtn);
    // Add button div to app
    announce.append(btnDiv);

    announceListDiv.append(announce);
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

