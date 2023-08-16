document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".nav-link");

  navLinks.forEach((link) => {
    link.addEventListener("click", handleScroll);
  });
});

function handleScroll(e) {
  e.preventDefault();

  const href = e.currentTarget.getAttribute("href");
  const targetId = href.replace(/.*#/, "");
  const element = document.getElementById(targetId);
  const links = document.querySelectorAll(".nav-link");

  element?.scrollIntoView({ behavior: "smooth" });
  links.forEach((link) => {
    link.classList.remove("active");
  });

  e.currentTarget.classList.add("active");
}