document.addEventListener("DOMContentLoaded", function () {
    let openPopUpPrev = document.getElementById("openPopUpPrev");
    let popup = document.getElementById("prevForm");
    let closePopup = document.getElementById("closePopUpPrev");

    openPopUpPrev.addEventListener("click", function () {
        popup.style.display = "block";
    });

    closePopup.addEventListener("click", function () {
        popup.style.display = "none";
    });

});

document.addEventListener("DOMContentLoaded", function () {
    let openPopUpPrev = document.getElementById("openPopUpReal");
    let popup = document.getElementById("realForm");
    let closePopup = document.getElementById("closePopUpReal");

    openPopUpPrev.addEventListener("click", function () {
        popup.style.display = "block";
    });

    closePopup.addEventListener("click", function () {
        popup.style.display = "none";
    });

});

