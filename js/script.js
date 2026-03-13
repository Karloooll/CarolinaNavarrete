// ✨=====================================================================✨
//
//                 CRAFTED WITH PASSION BY
//
//        ██╗  ██╗ █████╗ ██████╗ ██╗      ██████╗  ██████╗  ██████╗ ██╗     ██╗
//        ██║ ██╔╝██╔══██╗██╔══██╗██║     ██╔═══██╗██╔═══██╗██╔═══██╗██║     ██║
//        █████╔╝ ███████║██████╔╝██║     ██║   ██║██║   ██║██║   ██║██║     ██║
//        ██╔═██╗ ██╔══██║██╔══██╗██║     ██║   ██║██║   ██║██║   ██║██║     ██║
//        ██║  ██╗██║  ██║██║  ██║███████╗╚██████╔╝╚██████╔╝╚██████╔╝███████╗███████╗
//        ╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝╚══════╝ ╚═════╝  ╚═════╝  ╚═════╝ ╚══════╝╚══════╝
//
// ✨=====================================================================✨

console.log(
  "%c✨ Designed & Developed by Karloooll ✨",
  "color: #fdd947; background: #192a3d; font-size: 16px; padding: 10px 20px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-weight: bold; border: 2px solid #e44993; box-shadow: 0 4px 10px rgba(0,0,0,0.3);",
);

// Navbar scroll effect
window.addEventListener("scroll", () => {
  const nav = document.getElementById("navbar");
  if (window.scrollY > 50) {
    nav.classList.add("scrolled");
  } else {
    nav.classList.remove("scrolled");
  }
});

// Reveal animations on scroll
function reveal() {
  const reveals = document.querySelectorAll(".reveal");
  for (let i = 0; i < reveals.length; i++) {
    const windowHeight = window.innerHeight;
    const elementTop = reveals[i].getBoundingClientRect().top;
    const elementVisible = 100;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    }
  }
}

// Mobile Menu Toggle
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");
const overlay = document.getElementById("overlay");
const closeMenu = document.getElementById("close-menu");
const navItems = document.querySelectorAll(".nav-links a");

function toggleMenu() {
  navLinks.classList.toggle("active");
  overlay.classList.toggle("active");
}

hamburger.addEventListener("click", toggleMenu);
closeMenu.addEventListener("click", toggleMenu);
overlay.addEventListener("click", toggleMenu);

navItems.forEach((item) => {
  item.addEventListener("click", () => {
    if (navLinks.classList.contains("active")) {
      toggleMenu();
    }
  });
});

window.addEventListener("scroll", reveal);
// Trigger once on load
reveal();
