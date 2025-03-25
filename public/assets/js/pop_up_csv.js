
document.addEventListener("DOMContentLoaded", function () {
    let openPopUpPrev = document.getElementById("openPopUpCsv");
    let popup = document.getElementById("csvForm");
    let closePopup = document.getElementById("closePopUpCsv");

    openPopUpPrev.addEventListener("click", function () {
        popup.style.display = "block";
    });

    closePopup.addEventListener("click", function () {
        popup.style.display = "none";
    });

});

