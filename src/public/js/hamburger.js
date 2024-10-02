document.addEventListener("DOMContentLoaded", function () {
    let navToggle = document.querySelector(".nav_toggle");
    let nav = document.querySelector(".hamburger__nav");
    let searchForm = document.querySelector(".hamburger__search-form");
    navToggle.addEventListener("click", function () {
        navToggle.classList.toggle("show");
        nav.classList.toggle("show");
        searchForm.classList.toggle("show");
    });
});
