document.getElementById('file-input').addEventListener('change', function(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
        var img = document.getElementById('profileImage');
        img.src = reader.result;
    };

    reader.readAsDataURL(input.files[0]);
});