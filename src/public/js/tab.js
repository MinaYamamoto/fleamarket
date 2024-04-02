/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./resources/js/tab.js ***!
  \*****************************/
window.onload = function () {
  var tab1Button = document.querySelector('.tab__link[data-tab="tab1"]');
  tab1Button.classList.add('active');
  var tab1Content = document.getElementById('tab1');
  tab1Content.style.display = 'flex';
  var tab2Content = document.getElementById('tab2');
  tab2Content.style.display = 'none';
};
window.openTab = function (evt, tabName) {
  var i, card, tab__link;
  card = document.getElementsByClassName("card__list");
  for (i = 0; i < card.length; i++) {
    card[i].style.display = "none";
  }
  tab__link = document.getElementsByClassName("tab__link");
  for (i = 0; i < tab__link.length; i++) {
    tab__link[i].className = tab__link[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "flex";
  evt.currentTarget.className += " active";
};
/******/ })()
;