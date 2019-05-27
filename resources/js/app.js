/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


// Vanilla JS

(() => {
    // Handle the profile dropdown menu
    // =================================================================================

    const trigger = document.querySelector('.signin--list');
    const dropdown = document.querySelector('.dropdown');

    function hoverProfileEnter(e) {
        dropdown.style.display = 'block';
    }

    function hoverProfileLeave(e) {
        dropdown.style.display = 'none';    
    }

    trigger.addEventListener('mouseenter', hoverProfileEnter);
    trigger.addEventListener('mouseleave', hoverProfileLeave);

    // Navigation Menu for mobile
    // =================================================================================

    const menuBarButton = document.querySelector('.hamburger-header');
    const mobileNavMenu = document.querySelector('.mobile--navmenu');

    window.onresize = throttle(function () {
        checkWindowSize();
    }, 100);

    //Removes open mobile menu if window is resized above media query limit for mobile
    function checkWindowSize() {
        if (window.innerWidth > 950) {
            mobileNavMenu.style.display = 'none';
        }
    }

    //Toggle menu open and closed
    function toggleMenu() {
        if (mobileNavMenu.style.display == '' || mobileNavMenu.style.display == 'none') {
            mobileNavMenu.style.display = 'block';

        } else {
            mobileNavMenu.style.display = 'none';
        }
    }

    menuBarButton.addEventListener('click', toggleMenu);

    //Limits calls to checkWindowResize
    function throttle(func, limit) {
        let lastFunc;
        let lastRan;

        return function () {
            const context = this;
            const args = arguments;
            if (!lastRan) {
                func.apply(context, args);
                lastRan = Date.now();
            } else {
                clearTimeout(lastFunc);
                lastFunc = setTimeout(function () {
                    if ((Date.now() - lastRan) >= limit) {
                        func.apply(context, args);
                        lastRan = Date.now();
                    }
                }, limit - (Date.now() - lastRan))
            }
        }
    }

    // Display filename for uploaded images in upload.php
    // =================================================================================

    const fileUploadInput = document.querySelector('#image');
    const fileName = document.querySelector('.filename');

    function addFileTitle(e) {
        fileName.innerText = this.files[0].name;
    }

    if (fileUploadInput != null) {
        fileUploadInput.addEventListener('change', addFileTitle);
    }

    // Handles API call
    // =================================================================================

    function getClassicalImages() {
        const classicPost = document.querySelector('.post-container');

        const index = Math.floor(Math.random() * 60000);

        fetch('https://collectionapi.metmuseum.org/public/collection/v1/objects/' + index)
            .then(res => res.json())
            .then(data => {
                if (data.primaryImage == "" || data.primaryImage == undefined) getClassicalImages();
                else {
                    const info = `        
                        <h1>${data.title}</h1>
                        <h4>Date</h4>
                        <div class="post--image-container">
                            <img src="${data.primaryImage}" alt="upload">
                        </div>
                        <h4>Description</h4>
                        <p class="description"><strong>Artist: </strong>${data.constituents ? data.constituents[0].name : "N/A"}</p>
                        <p class="description"><strong>Medium: </strong>${data.medium ? data.medium : "N/A"}</p>
                        <p class="description"><strong>Location: </strong>${data.repository ? data.repository : "N/A"}</p>
                        <p class="description"><strong>Category: </strong>${data.classification ? data.classification : "N/A"}</p>
                        <p class="description"><strong>Cultural Origin: </strong>${data.culture ? data.culture : "N/A"}</p>
                        <p class="tags">View another randomly selected art piece courtesy of the Metropolitan Museum of Art.</p>
                        <p class="tags"><a href="classic.php" rel=""><strong>New art piece</strong></a></p>
                        `;
                    
                    classicPost.innerHTML = info;
                }
            });
    }

    const pages = document.URL.split('/');
    const page = pages[pages.length - 1]; 

    //Checks that the user is on the submissions/index page
    if (page === 'classic.php') {
        getClassicalImages();
    }
})();