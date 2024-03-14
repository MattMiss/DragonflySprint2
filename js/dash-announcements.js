$(window).on('load', () => {

    if (announceWasDeleted){
        showToast("Announcement was deleted!", 2000);
    }
});

function showViewAnnouncementModal(announcement){
    // Open view announcement modal
    $('#view-announcement-modal').modal('show');

    $('#view-announce-title').text(announcement.title);
    $('#view-announce-employer').text(announcement.ename);
    $('#view-announce-address').text(announcement.location);
    $('#view-announce-jurl').attr('href', announcement.jurl);
    $('#view-announce-info').text(announcement.additional_info);
}

function showDeleteAnnouncementModal(announcement){
    // Open delete annoucnement Modal
    $('#delete-announcement-modal').modal('show');

    $('#delete-announce-title').text(announcement.title);
    $('#delete-announcement-id').val(announcement.announcement_id);
}