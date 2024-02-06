let darkModeSwitch;
let footerJobsSection;
let footerResourcesSection;

window.addEventListener('load', function() {
    //console.log("Window loaded");
    setupDarkMode();
    setupFooterListener();
});

function setupDarkMode(){
    //console.log("Setup dark mode");
    darkModeSwitch = document.getElementById("dark-mode-switch");
    console.log(darkModeSwitch);
    if (theme !== null){
        setDarkMode(theme);
        darkModeSwitch.checked = theme === 'dark';
    }else
    {
        localStorage.setItem('theme','light');
    }

    darkModeSwitch.addEventListener("change", () => {
        theme === 'light' ? setDarkMode('dark') : setDarkMode('light');
    });
}

function setDarkMode(newTheme){
    //console.log("Changed to : " + newTheme);
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    theme = newTheme;
}

function setupFooterListener(){
    // Set footer sections refs
    footerJobsSection = document.getElementById('footer-jobs');
    footerResourcesSection = document.getElementById('footer-resources');

    // Set onclick events for footer buttons
    jobsBtn = document.getElementById('footer-jobs-btn');
    jobsBtn.addEventListener("click", () => {
        changeFooter('showJobs');
    })
    resourcesBtn = document.getElementById('footer-resources-btn');
    resourcesBtn.addEventListener("click", () => {
        changeFooter('showResources');
    })
}

function changeFooter(showType){
    switch(showType){
        case 'showJobs':
            // Set jobs button to 'showing'
            jobsBtn.classList.add('showing');
            resourcesBtn.classList.remove('showing');

            // Show Jobs - Hide Resources
            footerJobsSection.classList.remove('footer-hide');
            footerJobsSection.classList.add('footer-show');
            footerResourcesSection.classList.add('footer-hide');
            footerResourcesSection.classList.remove('footer-show');


            break;
        case 'showResources':
            // Set resources button to 'showing'
            jobsBtn.classList.remove('showing');
            resourcesBtn.classList.add('showing');

            // Show Resources - Hide Jobs
            footerJobsSection.classList.remove('footer-show');
            footerJobsSection.classList.add('footer-hide');
            footerResourcesSection.classList.add('footer-show');
            footerResourcesSection.classList.remove('footer-hide');
            break;
    }
    window.scrollTo(0, document.body.scrollHeight);
}

console.log("Main loaded");