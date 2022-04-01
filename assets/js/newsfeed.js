const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let newsQ;
if (urlParams.get("c")) {
  newsQ = urlParams.get("c");
} else {
  newsQ = "crypto";
}
console.log(newsQ);
var today = new Date();
var url =
  "http://newsapi.org/v2/everything?" +
  `q=$${newsQ}&` +
  `from=${today.getFullYear()}-${String(today.getMonth() + 1).padStart(
    2,
    "0"
  )}-${String(today.getDate()).padStart(2, "0")}&` +
  "sortBy=recent&" +
  "language=en&" +
  "totalResults=6&" +
  "apiKey=d1f50b000e04422eb7cbab0b4e354adb";
var req = new Request(url);
const articlseDiv = document.querySelector("#articles");
fetch(req)
  .then(function (response) {
    return response.json();
  })
  .then((data) => {
    console.log(data["articles"]);
    for (let article of data["articles"]) {
      let newArticle = document.createElement("div");
      newArticle.className = "card m-3 p-3";
      newArticle.innerHTML = `<div class="row">
                    <a id="chart-title" class="m-1 text-uppercase text-primary text-lg font-weight-bolder opacity-9" href="${article["url"]}">
                    ${article["title"]}   
                </a>
            </div>
            <a class="row"  href="${article["url"]}">
                <p class="col-4">${article["description"]}</p>
                <img class="col-8 ml-auto" style="border:solid purple 0rem; border-radius:4rem;" src="${article["urlToImage"]}"></img>
            </a>`;
      articlseDiv.appendChild(newArticle);
    }
  });
