const hamburger = document.getElementsByClassName('js-hamburger');
const nav = document.getElementsByClassName('js-nav');
const navLink = document.getElementsByClassName('l-header-nav__link');
const mask = document.getElementsByClassName('l-header__mask');




if (window.matchMedia("(max-width: 768px)").matches) {
    hamburger[0].addEventListener('click', toggleBurger);
    mask[0].addEventListener('click', removeBurger);
    mask[0].addEventListener('mousewheel', removeBurger);

    for (var i = 0; i < navLink.length; i++) {
        navLink[i].addEventListener('click', removeBurger);
    }
}

function removeBurger() {
    hamburger[0].classList.remove('is-active');
    nav[0].classList.remove('is-active');
    mask[0].classList.remove('is-active');
}

function toggleBurger() {
    hamburger[0].classList.toggle('is-active');
    nav[0].classList.toggle('is-active');
    mask[0].classList.toggle('is-active');
}

const deleteLink = document.querySelectorAll('.table__td--delete');
const modal = document.querySelectorAll('.table__modal');
const modalFalse = document.querySelectorAll('.table__modal--button-false');
for (let i = 0; i < modal.length; i++) {
    deleteLink[i].addEventListener('click', function() {
        modal[i].classList.add('is-show');
    });
    
    modalFalse[i].addEventListener('click', function() {
        modal[i].classList.remove('is-show');
    });
}

