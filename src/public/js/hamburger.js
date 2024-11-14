document.addEventListener("DOMContentLoaded", function () {
    let navToggle = document.querySelector(".header__hamburger-button");
    let nav = document.querySelector(".header__hamburger-nav");
    let searchForm = document.querySelector(".header__hamburger-search-form");
    navToggle.addEventListener("click", function () {
        navToggle.classList.toggle("show");
        nav.classList.toggle("show");
        searchForm.classList.toggle("show");
    });
});
