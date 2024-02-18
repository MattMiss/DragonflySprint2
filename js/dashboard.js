function deleteAppBtnClicked(appInfo) {
    //console.log("asking to delete app from " + appInfo['ename']);
    //console.log(appInfo['application_id']);

    const modal = $('#modalText');
    modal.textContent = "Delete application from " + appInfo['ename'] + "?";

    const dltBtn = document.getElementById('deleteAppBtn');

    const dltHandler = () => {
        console.log("Deleting App: " + 'app-' + appInfo['application_id']);
        const app = $('#app-' + appInfo['application_id']);
        if (app) {
            app.remove();
            modal.textContent = "";
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