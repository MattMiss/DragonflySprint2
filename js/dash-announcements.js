let sortedAnnouncements = announcements;
const announceListDiv = $('#dash-announcements-list');


$(window).on('load', () => {

    document.addEventListener('dateFormatChanged', (e)=>{
        console.log("Date Changed");
        emptyAnnouncementList()
        populateAnnouncementList();
    }, true)

    emptyAnnouncementList();
    populateAnnouncementList();

    if (announceWasDeleted){
        showToast("Announcement was deleted!", 2000);
    }
});

function emptyAnnouncementList(){
    announceListDiv.empty();
}

// Loop through each application in sortedApps and create a <tr> with all the fields filled in
function populateAnnouncementList(){
    if (sortedAnnouncements.length === 0){
        const noResults = '<tr class="user-list-item">\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '<td class="text-center">No Announcements</td>\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '</tr>';
        announceListDiv.append(noResults);
    }

    for(let i = 0; i < sortedAnnouncements.length; i++){
        createAnnounceFromData(sortedAnnouncements[i]);
    }
}

function createAnnounceFromData(announceData){
    console.log(announceData);

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

function askToDeleteAnnouncement(announce_id){

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

