// Guest counter modal logic (simplified - needs guest modal HTML)
// Note: guestModal HTML not present in index.blade.php, so basic implementation
let guestCount = { adults: 2, children: 0, rooms: 1 };

function openGuestModal() {
    // For now, just log - full modal needs HTML structure
    console.log("Guest modal opened");
}

function updateGuestDisplay() {
    document.getElementById("guestDisplay").textContent =
        `${guestCount.adults} Dewasa, ${guestCount.rooms} Kamar`;
}

// Placeholder functions for tabs (only apartment tab active)
function setSearchTab(button, tab) {
    document
        .querySelectorAll(".search-tab")
        .forEach((btn) => btn.classList.remove("bg-white", "text-brand"));
    button.classList.add("bg-white", "text-brand");
}

// Main search handler
function handleSearch() {
    const searchDest = document.getElementById("searchDest").value || "";
    const checkin = document.getElementById("checkin").value || "";
    const checkout = document.getElementById("checkout").value || "";
    const guests = `${guestCount.adults + guestCount.children}` || "2";

    // Build query string
    const params = new URLSearchParams();
    if (searchDest) params.append("search", searchDest);
    if (checkin) params.append("checkin", checkin);
    if (checkout) params.append("checkout", checkout);
    if (guests) params.append("tamu", guests);

    // Redirect to list-apartments with filters
    window.location.href = `/list-apartments?${params.toString()}`;
}

// Expose to global scope for onclick handlers
window.handleSearch = handleSearch;
window.setSearchTab = setSearchTab;
window.openModal = openGuestModal;
window.updateGuestDisplay = updateGuestDisplay;
