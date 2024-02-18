function userSelected(userInfo){
    console.log("User ID: " + userInfo['email']);
    $('#sent-to').val(userInfo['email']);
    $('#first-name').val(userInfo['fname']);
    $('#last-name').val(userInfo['lname']);
    $('#selectUserModal').modal('toggle');
}
