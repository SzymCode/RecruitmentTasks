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

  imageLinks.forEach(imgSrc => {
    const imgDiv = document.createElement('div');
    imgDiv.className = 'overflow-hidden';

    const img = document.createElement('img');
    img.className = 'hover:scale-125 duration-1000 w-full h-full ease-out cursor-zoom-in hover-dark' ;
    img.src = imgSrc;
    img.alt = '';

    img.addEventListener('click', () => {
      popupImg.src = imgSrc;
      popupDiv.classList.remove('hidden');
    });

    imgDiv.appendChild(img);
    imageDisplay.appendChild(imgDiv);
  });

  popupDiv.addEventListener('click', () => {
    popupDiv.classList.add('hidden');
  });
});