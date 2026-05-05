let currentSlide = 0;
// image list (paths)
let images = [];

// Autoplay control: true by default
window.sliderAutoplay = true;

function initSlider() {
    images = window.apartmentImages || [];
    if (images.length === 0) return;

    showSlide(0); // Ensure first slide is shown
    // Auto slide every 5 seconds
    window.sliderAutoplay = true;
    if (window.sliderInterval) clearInterval(window.sliderInterval);
    window.sliderInterval = setInterval(nextSlide, 5000);
}

function showSlide(index) {
    document.querySelectorAll(".slider-img").forEach((img, i) => {
        img.style.opacity = i === index ? "1" : "0";
    });
    document.querySelectorAll(".slider-dot").forEach((dot, i) => {
        dot.classList.toggle("bg-white", i === index);
        dot.classList.toggle("bg-white/50", i !== index);
    });
    currentSlide = index;

    // Restart auto-slide interval only if autoplay not stopped by user
    if (window.sliderInterval) clearInterval(window.sliderInterval);
    if (window.sliderAutoplay !== false) {
        window.sliderInterval = setInterval(nextSlide, 5000);
    }
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % images.length;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + images.length) % images.length;
    showSlide(currentSlide);
}

function stopAutoplay() {
    window.sliderAutoplay = false;
    if (window.sliderInterval) {
        clearInterval(window.sliderInterval);
        window.sliderInterval = null;
    }
}

function goToSlide(index, userInitiated = true) {
    if (userInitiated) stopAutoplay();
    showSlide(index);
}

// Zoom functionality
document.addEventListener("click", function (e) {
    if (
        e.target.classList.contains("slider-img") &&
        !e.target.classList.contains("zoomed")
    ) {
        e.target.classList.add("zoomed");
        e.target.style.transform = "scale(1.5)";
        e.target.style.zIndex = "1000";
        e.target.style.transition = "transform 0.3s ease";
        document.body.style.overflow = "hidden";

        // Close on click outside or ESC
        setTimeout(() => {
            const closeZoom = (ev) => {
                if (ev.target === e.target || ev.key === "Escape") {
                    e.target.classList.remove("zoomed");
                    e.target.style.transform = "";
                    e.target.style.zIndex = "";
                    document.body.style.overflow = "";
                    document.removeEventListener("click", closeZoom);
                    document.removeEventListener("keydown", closeZoom);
                }
            };
            document.addEventListener("click", closeZoom);
            document.addEventListener("keydown", closeZoom);
        }, 100);
    }
});

// Expose to global
window.initSlider = initSlider;
window.goToSlide = goToSlide;
window.nextSlide = nextSlide;
window.prevSlide = prevSlide;

// Add arrow navigation
document.addEventListener("DOMContentLoaded", function () {
    const prevBtn = document.getElementById("prevSlide");
    const nextBtn = document.getElementById("nextSlide");

    if (prevBtn) {
        prevBtn.addEventListener("click", function (ev) {
            stopAutoplay();
            prevSlide();
        });
    }
    if (nextBtn) {
        nextBtn.addEventListener("click", function (ev) {
            stopAutoplay();
            nextSlide();
        });
    }

    // Touch/swipe for mobile
    let startX = 0;
    let currentX = 0;

    const slider = document.getElementById("imageSlider");
    if (slider) {
        slider.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
        });

        slider.addEventListener("touchmove", (e) => {
            currentX = e.touches[0].clientX;
        });

        slider.addEventListener("touchend", (e) => {
            const diff = startX - currentX;
            if (Math.abs(diff) > 50) {
                // Minimum swipe distance — treat as user interaction
                stopAutoplay();
                if (diff > 0) {
                    nextSlide(); // Swipe left -> next
                } else {
                    prevSlide(); // Swipe right -> prev
                }
            }
        });
    }
});

// Auto-init if apartmentImages present when script loads
(function () {
    if (window.apartmentImages && window.apartmentImages.length > 0) {
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initSlider);
        } else {
            initSlider();
        }
    }
})();
