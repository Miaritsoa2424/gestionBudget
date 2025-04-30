document.addEventListener("DOMContentLoaded", function () {
    let openPopUpPrev = document.getElementById("openPopUpCrm");
    let popup = document.getElementById("crmForm");
    let closePopup = document.getElementById("closePopUpCrm");

    openPopUpPrev.addEventListener("click", function () {
        popup.style.display = "block";
    });

    closePopup.addEventListener("click", function () {
        popup.style.display = "none";
    });

});