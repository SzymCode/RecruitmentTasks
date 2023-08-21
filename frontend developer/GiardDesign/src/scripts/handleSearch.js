function toggleSearch() {
  const searchInput = document.getElementById('searchInput');

  if (!searchInput.classList.contains('translate-x-5')) {
    searchInput.classList.add('translate-x-5');
    searchInput.classList.remove('opacity-0');
  } else {
    searchInput.classList.remove('translate-x-5');
    searchInput.classList.add('opacity-0');
  }
}