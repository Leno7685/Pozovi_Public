window.addEventListener("beforeunload", function () {
    localStorage.setItem("scrollPos_eventPage", window.scrollY);
});

window.addEventListener("load", function () {
    const scrollPos = localStorage.getItem("scrollPos_eventPage");
    if (scrollPos) {
        window.scrollTo({ top: parseInt(scrollPos), behavior: 'auto' });
    }
});


const locationInput = document.getElementById("event_location");
const mapsLinkDiv = document.getElementById("google-maps-link");
const mapsLink = document.getElementById("maps-link");

locationInput.addEventListener("input", () => {
    const location = locationInput.value.trim();
    if (location) {
        mapsLink.href = `https://www.google.com/maps?q=${encodeURIComponent(location)}`;
        mapsLinkDiv.style.display = "block";
    } else {
        mapsLinkDiv.style.display = "none";
    }
});


function showGiftPopup(event, popupId, name, link, reserved, giftId) {
    let popup = document.getElementById(popupId);
    //document.getElementById("invitee-popup").style.display = 'none';
    popup.style.display = 'block';

    popup.style.top = event.pageY + 0 + 'px';
    popup.style.left = event.pageX - 5 + 'px';

    document.getElementById('popup-name-input2').value = name;
    document.getElementById('popup-link-input').value = link;
    document.getElementById('popup-id2').value = giftId;
    let msg = (reserved === 'reserved') ? 'Rezervisano' :
        (reserved === 'available') ? 'Nije rezervisano' : 'Nepoznat status';
    document.getElementById('popup-reserved').innerText = `Status poklona: ${msg}`;
}


function closePopup(popupId) {
    document.getElementById(popupId).style.display = 'none';
}


const deletedGifts = [];

document.querySelectorAll("#gift-x").forEach((btn, index) => {
    btn.addEventListener("click", (e) => {
        e.stopPropagation();
        document.getElementById("potvrdi2").style.display = 'block';
        const giftElement = btn.closest(".modal-header");
        const giftId = giftsData[index];

        deletedGifts.push(giftId);
        giftElement.parentElement.remove();

        document.getElementById("deleted_gifts").value = JSON.stringify(deletedGifts);
    });
});
