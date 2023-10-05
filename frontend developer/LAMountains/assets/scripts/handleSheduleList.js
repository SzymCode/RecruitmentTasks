function renderDivs(elements, classPrefix) {
  var ulElement = document.getElementById("shedule-list");
  elements.forEach(function(item, index) {
    var liElement = document.createElement("li");
    var dateParagraph = document.createElement("p");
    var textParagraph = document.createElement("p");

    dateParagraph.textContent = item[0];
    textParagraph.textContent = item[1];

    liElement.classList.add(classPrefix);

    liElement.appendChild(dateParagraph);
    liElement.appendChild(textParagraph);

    ulElement.appendChild(liElement);
  });
}

document.addEventListener("DOMContentLoaded", function() {
  var elements1 = [
    ["25 Nov 2016", "Vestibulum viverra"],
    ["28 Nov 2016", "Vestibulum viverra"],
    ["", ""],
    ["18 Dec 2016", "Vestibulum viverra"],
    ["", ""],
    ["7 Jan 2017", "Vestibulum viverra"]
  ];

  var elements2 = [
    ["17 Nov 2016", "Vestibulum viverra"],
    ["", ""],
    ["13 Dec 2016", "Vestibulum viverra"],
    ["28 Dec 2016", "Vestibulum viverra"],
    ["", ""],
    ["9 Feb 2017", "Vestibulum viverra"]
  ];

  renderDivs(elements1, "element1");
  renderDivs(elements2, "element2");
});
