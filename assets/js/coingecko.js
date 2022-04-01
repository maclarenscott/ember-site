const title = document.querySelector("#chart-title");
const chartBtns = document.querySelectorAll("#chart-btn");
// console.dir(chartBtns);
function dateToWords(unixTS){
    const now = Date.now();
    const date = new Date(unixTS);
    const dateWordsArr = date.toDateString().split(' ');
    // console.log(parseInt(now) - parseInt(unixTS));
    if ((parseInt(now) - parseInt(unixTS)) > 32000000000){
        
        return `${dateWordsArr[1]} ${dateWordsArr[3]}`;
    }
    else if ((parseInt(now) - parseInt(unixTS)) > 2592000000){
        
        return `${dateWordsArr[1]} ${dateWordsArr[2].replace(/^0+/, '')}`;
    }
    else if ((parseInt(now) - parseInt(unixTS)) > 600000000){
        
        return `${dateWordsArr[2].replace(/^0+/, '')}`;
    }
    else{
        return `${dateWordsArr[0]}`;
    }
}

var TimeAgo = (function () {
  var self = {};

  // Public Methods
  self.locales = {
    prefix: "",
    sufix: "",

    seconds: "Now",
    minute: "1 minute",
    minutes: "%d minutes",
    hour: "1 hour",
    hours: "%d hours",
    day: "1 day",
    days: "%d days",
    month: "1 month",
    months: "%d months",
    year: "1 year",
    years: "%d years",
  };

  self.inWords = function (timeAgo) {
    var seconds = Math.floor((new Date() - parseInt(timeAgo)) / 1000),
      separator = this.locales.separator || " ",
      words = this.locales.prefix + separator,
      interval = 0,
      intervals = {
        year: seconds / 31536000,
        month: seconds / 2592000,
        day: seconds / 86400,
        hour: seconds / 3600,
        minute: seconds / 60,
      };

    var distance = this.locales.seconds;

    for (var key in intervals) {
      interval = Math.floor(intervals[key]);

      if (interval > 1) {
        distance = this.locales[key + "s"];
        break;
      } else if (interval === 1) {
        distance = this.locales[key];
        break;
      }
    }

    distance = distance.replace(/%d/i, interval);
    words += distance + separator + this.locales.sufix;

    return words.trim();
  };

  return self;
})();

getData = function (coin, days) {
  let url;
  if (parseInt(days) < 2) {
    url =
      "http://api.coingecko.com/api/v3/coins/" +
      coin +
      "/market_chart?vs_currency=usd&days=" +
      days +
      "&interval=minutely";
  } else {
    url =
      "http://api.coingecko.com/api/v3/coins/" +
      coin +
      "/market_chart?vs_currency=usd&days=" +
      days +
      "&interval=hourly";
  }
  return fetch(url)
    .then((response) => response.json())
    .then((data) => {
      prices = [...data["prices"].map((index) => parseFloat(index[1]))];
      let iter = 0;
      times = [
        ...data["prices"].map((index) => {
          iter++;
          if (iter % Math.ceil((data["prices"].length/40)) == 0) {
            let date = parseInt(index[0]);
            // return TimeAgo.inWords(date.getTime());
            return dateToWords(date);
          } else {
            return "";
          }
        }),
      ];
      return [prices, times];
    });
};
let myChart;
const buildGraph = (days) => {
    
    try {
      myChart.destroy();
    } catch {
      console.log("couldn't destroy");
    }
    
    // console.log(days);
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    title.innerText = urlParams.get("c");
    const retData = getData(urlParams.get("c"), days).then((result) => {
      // console.log(result);

      const data = {
        labels: result[1],
        datasets: [
          {
            label: "",
            backgroundColor: "rgb(202, 11, 159)",
            borderColor: "rgb(202, 11, 159)",
            //   data: [35, 30, 5, 25, 20, 30, 45, 25, 35, 30, 60, 66],
            data: result[0],
            fill: false,
            pointRadius: 0,
          },
        ],
      };

      const config = {
        type: "line",
        data: data,
        maintainAspectRatio: false,
        responsive: true,
        options: {
          maintainAspectRatio: false,
          tension: 0.1,
          plugins: {
            legend: {
              display: false,
            },
          },
          scales: {
            x: {
              grid: {
                display: false,
              },
            },
            y: {
              grid: {
                display: false,
              },
            },
            
          },
        },
      };

      myChart = new Chart(document.querySelector("#portfolio-chart"), config);
    });
  }
for (let btn of chartBtns) {
  btn.addEventListener("click", buildGraph.bind(this,btn.dataset.time));
}

buildGraph(1);