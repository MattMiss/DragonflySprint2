const newPassDiv = $('#user-edit-new-pass');
$(window).on('load', () => {
   $('#user-edit-pass-select').on('change', (e) => {
       if (e.target.value === 'new'){
            newPassDiv.removeClass('hidden');
       }else if(e.target.value === 'same'){
           newPassDiv.addClass('hidden');
       }
    })
});