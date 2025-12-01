const menuButton = document.getElementById("menu-button");
const navLinks = document.getElementById("nav-links");

menuButton.addEventListener("click", () => {
    navLinks.style.display = navLinks.style.display === "flex" ? "none" : "flex";
});

const fadeElements = document.querySelectorAll(".fade-up");

const fadeInOnScroll = () => {
    fadeElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight - 80) {
            el.classList.add("show");
        }
    });
};

window.addEventListener("scroll", fadeInOnScroll);
fadeInOnScroll();

const form = document.getElementById("contact-form");
const status = document.getElementById("form-status");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    status.textContent = "✔ Message sent successfully!";
    status.style.color = "cyan";
    status.style.marginTop = "10px";

    form.reset();

    setTimeout(() => status.textContent = "", 3000);
});
