/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/sellimg.js ***!
  \*********************************/
document.getElementById('file-input').addEventListener('change', function (event) {
  var input = event.target;
  var reader = new FileReader();
  reader.onload = function () {
    var img = document.getElementById('sellImage');
    img.src = reader.result;
  };
  reader.readAsDataURL(input.files[0]);
});
window.previewImage = function (event) {
  var imagePreview = document.getElementById('imagePreview');
  var sellImage = document.getElementById('sellImage');
  var fileInput = event.target;
  if (fileInput.files && fileInput.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      sellImage.src = e.target.result;
      imagePreview.hidden = false;
    };
    reader.readAsDataURL(fileInput.files[0]);
  }
};
/******/ })()
;