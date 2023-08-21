document.addEventListener("DOMContentLoaded", function () {
  const mobileMenuIcon = document.getElementById('mobileMenuIcon');
  const mobileMenu = document.getElementById('mobileMenu');

  mobileMenuIcon.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
});
function toggleOfferDivs() {
  const projectsDiv = document.getElementById('projectsDiv');
  const visualizationsDiv = document.getElementById('visualizationsDiv');
  const realizationsDiv = document.getElementById('realizationsDiv');

  projectsDiv.classList.toggle('hidden');
  visualizationsDiv.classList.toggle('hidden');
  realizationsDiv.classList.toggle('hidden');
}