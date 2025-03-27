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
                        top: targetElement.offsetTop - navbarHeight - 10, // Adjust to prevent overlap
                        behavior: "smooth"
                    });
                }

                // Close the offcanvas menu properly
                const offcanvas = document.querySelector("#offcanvasNavbar");
                if (offcanvas) {
                    const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvas) || new bootstrap.Offcanvas(offcanvas);
                    offcanvasInstance.hide();
                }
            }
        });
    });

    // Ensure the backdrop is removed when offcanvas is closed
    document.getElementById('offcanvasNavbar').addEventListener('hidden.bs.offcanvas', function () {
        document.body.classList.remove('offcanvas-backdrop');
    });
});
