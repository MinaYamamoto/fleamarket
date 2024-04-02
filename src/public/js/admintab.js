/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/admintab.js ***!
  \**********************************/
window.onload = function () {
  var tab1Button = document.querySelector('.tab__button[data-tab="tab1"]');
  tab1Button.classList.add('active');
  var tab1Content = document.getElementById('tab1');
  tab1Content.style.display = 'block';
  var tab2Content = document.getElementById('tab2');
  tab2Content.style.display = 'none';
  var tab2Content = document.getElementById('tab3');
  tab2Content.style.display = 'none';
};
window.openTab = function (evt, tabName) {
  var i, tab__link, tab__button;
  tab__link = document.getElementsByClassName("tab__link");
  for (i = 0; i < tab__link.length; i++) {
    tab__link[i].style.display = "none";
  }
  tab__button = document.getElementsByClassName("tab__button");
  for (i = 0; i < tab__button.length; i++) {
    tab__button[i].className = tab__button[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
};
/******/ })()
;