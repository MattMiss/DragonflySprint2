$(window).on('load', () => {
    $('.dropdown-menu').on("click.bs.dropdown", function(e) {
        // Stop Propagation prevents the dropdown-menu from closing when a dropdown-item is clicked
        // This is needed to stop the menu from closing when the dark mode switch is clicked
        e.stopPropagation();
        //e.preventDefault();
    })
})