let track = document.querySelector('.testimonial-track');
let prevBtn = document.querySelector('.prev-btn');
let nextBtn = document.querySelector('.next-btn');
let cardWidth = document.querySelector('.testimonial-card').offsetWidth + 20;
let totalCards = track.children.length;
let index = 0;
let visibleCards;

// Limit the number of testimonial cards to 10
if (totalCards > 10) {
    while (track.children.length > 10) {
        track.removeChild(track.lastElementChild);
    }
    totalCards = 10; // Update totalCards after removing extra ones
}

function updateVisibleCards() {
    let wrapperWidth = document.querySelector('.testimonial-track-wrapper').offsetWidth;

    // Show only 1 card per slide on smaller screens
    visibleCards = window.innerWidth < 768 ? 1 : Math.floor(wrapperWidth / cardWidth);

    track.style.transform = `translateX(-${index * cardWidth}px)`;
    updateButtons();
}

// Update on resize
window.addEventListener('resize', () => {
    cardWidth = document.querySelector('.testimonial-card').offsetWidth + 20;
    updateVisibleCards();
});

nextBtn.addEventListener('click', () => {
    if (index < totalCards - visibleCards) {
        index++;
        track.style.transform = `translateX(-${index * cardWidth}px)`;
    }
    updateButtons();
});

prevBtn.addEventListener('click', () => {
    if (index > 0) {
        index--;
        track.style.transform = `translateX(-${index * cardWidth}px)`;
    }
    updateButtons();
});

function updateButtons() {
    prevBtn.style.opacity = index === 0 ? "0.5" : "1";
    prevBtn.style.pointerEvents = index === 0 ? "none" : "auto";

    nextBtn.style.opacity = index >= totalCards - visibleCards ? "0.5" : "1";
    nextBtn.style.pointerEvents = index >= totalCards - visibleCards ? "none" : "auto";
}

// Initial setup
updateVisibleCards();
