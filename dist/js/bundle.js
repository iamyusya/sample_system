"use strict";

var hamburger = document.getElementsByClassName('js-hamburger');
var nav = document.getElementsByClassName('js-nav');
var navLink = document.getElementsByClassName('l-header-nav__link');
var mask = document.getElementsByClassName('l-header__mask');

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

var deleteLink = document.querySelectorAll('.table__td--delete');
var modal = document.querySelectorAll('.table__modal');
var modalFalse = document.querySelectorAll('.table__modal--button-false');

var _loop = function _loop(_i) {
  deleteLink[_i].addEventListener('click', function () {
    modal[_i].classList.add('is-show');
  });

  modalFalse[_i].addEventListener('click', function () {
    modal[_i].classList.remove('is-show');
  });
};

for (var _i = 0; _i < modal.length; _i++) {
  _loop(_i);
}