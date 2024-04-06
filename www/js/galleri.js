const modal = document.getElementById('modal');
const modalImg = document.getElementById("modal-content");
const captionText = document.getElementById("modal-caption");

document.addEventListener('click', function (e) { 
    if (e.target.className.indexOf('modal-target') !== -1) {
        // Open modal
        const img = e.target;
        modal.style.display = "block";
        modalImg.src = img.dataset.fullsrc;
        captionText.innerHTML = img.alt;
    } else if (modal.style.display != "none") {
        // Close modal
        modal.style.display = "none";
        modalImg.src = "";
    }
});
