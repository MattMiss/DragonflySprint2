const newPassDiv = $('#user-edit-new-pass');
const passReqsDiv = $('#user-edit-pass-reqs');
$(window).on('load', () => {
    validatePass = false;
   $('#user-edit-pass-select').on('change', (e) => {
       if (e.target.value === 'new'){
           newPassDiv.removeClass('hidden');
           passReqsDiv.removeClass('hidden');
           validatePass = true;
       }else if(e.target.value === 'same'){
           validatePass = false;
           newPassDiv.addClass('hidden');
           passReqsDiv.addClass('hidden');
       }
    })
});