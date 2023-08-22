document.addEventListener("DOMContentLoaded", function () {
  const imageLinks = [
    "src/img/photo.png", "src/img/photo-2.png", "src/img/photo-3.png", "src/img/photo-4.png", "src/img/photo-5.png",
    "src/img/photo-6.png", "src/img/photo-7.png", "src/img/photo-8.png", "src/img/photo-9.png", "src/img/photo-10.png",
    "src/img/photo.png", "src/img/photo-2.png", "src/img/photo-3.png", "src/img/photo-4.png", "src/img/photo-5.png",
    "src/img/photo-6.png", "src/img/photo-7.png", "src/img/photo-8.png", "src/img/photo-9.png", "src/img/photo-10.png",
    "src/img/photo.png", "src/img/photo-2.png",
  ];

  const imageDisplay = document.getElementById('imageContainer');
  const popupDiv = document.getElementById('popupDiv');
  const popupImg = document.getElementById('popupImg');
  const prevButton = document.getElementById('prevButton');
  const nextButton = document.getElementById('nextButton');
  let currentImageIndex = 0;

  imageLinks.forEach((imgSrc, index) => {
    const imgDiv = document.createElement('div');
    imgDiv.className = 'overflow-hidden';

    const img = document.createElement('img');
    img.className = 'hover:scale-125 duration-1000 w-full h-full ease-out cursor-zoom-in hover-dark' ;
    img.src = imgSrc;
    img.alt = '';

    img.addEventListener('click', () => {
      currentImageIndex = index;
      popupImg.src = imgSrc;
      popupDiv.classList.remove('hidden');
    });

    imgDiv.appendChild(img);
    imageDisplay.appendChild(imgDiv);
  });

  prevButton.addEventListener('click', () => {
    if (currentImageIndex > 0) {
      currentImageIndex--;
      popupImg.src = imageLinks[currentImageIndex];
    }
  });

  nextButton.addEventListener('click', () => {
    if (currentImageIndex < imageLinks.length - 1) {
      currentImageIndex++;
      popupImg.src = imageLinks[currentImageIndex];
    }
  });

  popupDiv.addEventListener('click', (event) => {
    if (event.target === popupDiv || event.target === popupImg) {
      popupDiv.classList.add('hidden');
    }
  });
});