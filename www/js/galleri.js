// #region Modal
var modal = document.getElementById('modal');

// global handler
document.addEventListener('click', function (e) { 
    if (e.target.className.indexOf('modal-target') !== -1) {
        var img = e.target;
        var modalImg = document.getElementById("modal-content");
        var captionText = document.getElementById("modal-caption");
        modal.style.display = "block";
        modalImg.src = img.src;
        captionText.innerHTML = img.alt;
    } else if (modal.style.display != "none") {
        modal.style.display = "none";
    }
});
// #endregion

// #region sorting


// #endregion