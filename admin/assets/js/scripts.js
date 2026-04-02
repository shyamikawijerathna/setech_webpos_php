/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // 1. Select the toggle button
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    
    if (sidebarToggle) {
        // 2. CHECK PERSISTENCE ON LOAD
        // If the 'true' value exists in storage, apply the toggled class immediately
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.add('sb-sidenav-toggled');
        }

        // 3. HANDLE THE CLICK
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            
            // Toggle the class on the body
            document.body.classList.toggle('sb-sidenav-toggled');
            
            // Save the current state (true or false) to localStorage
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
});
