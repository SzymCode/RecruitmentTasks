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
});