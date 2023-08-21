document.addEventListener("DOMContentLoaded", function () {
  var macy = Macy({
    container: ".photos",
    trueOrder: false,
    waitForImages: false,
    margin: 30,
    columns: 3,
    breakAt: {
      1400: {
        margin: 20,
      },
      900: {
        margin: 15,
      },
    },
  });

  const viewMoreContainer = document.getElementById("imageContainer");
  const expandButton = document.getElementById("expandButton");
  function togglePhotos() {
    const isSmallWidth = window.innerWidth < 900;
    const isExpanded = isSmallWidth ? viewMoreContainer.style.maxHeight === "600px" : viewMoreContainer.style.maxHeight === "2000px";

    if (isExpanded) {
      const newMaxHeight = isSmallWidth ? "2000px" : "7000px";
      viewMoreContainer.style.maxHeight = newMaxHeight;
      expandButton.querySelector("#ctaText").textContent = "Zwiń";
    } else {
      viewMoreContainer.style.maxHeight = isSmallWidth ? "600px" : "2000px";
      expandButton.querySelector("#ctaText").textContent = "Rozwiń";
    }
    macy.recalculate(true);
  }
  expandButton.addEventListener("click", togglePhotos);
  window.addEventListener("resize", togglePhotos);
});