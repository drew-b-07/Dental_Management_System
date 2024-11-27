document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".nav-link");
    const sections = document.querySelectorAll(".section");

    navLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            
            navLinks.forEach(link => link.classList.remove("active"));

            
            link.classList.add("active");

            
            sections.forEach(section => section.classList.remove("active"));

            
            const sectionId = link.getAttribute("data-section");
            document.getElementById(sectionId).classList.add("active");
        });
    });
});

