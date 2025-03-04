document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".nav-link").forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href");
            if (targetId.startsWith("#")) {
                e.preventDefault();
                const targetElement = document.querySelector(targetId);
                const navbarHeight = document.querySelector(".navbar").offsetHeight;

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - navbarHeight - 10, // Adjust para hindi matakpan
                        behavior: "smooth"
                    });
                }
            }
        });
    });
});