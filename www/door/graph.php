<?php
require_once dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/events.css">
    <meta name="theme-color" content="#024" />
    <title>Inngangsverkstedet</title>
    <style>
      body {
        text-align: center;
        width: 80vw;
        margin: auto auto;
      }

      #graphDiv {
        display: flex;
        flex-direction: column;
      }

      .graphbox {
        margin: 20px;
        padding: 10px;
        border: 5px solid #00407F;
        border-radius: 10px;
      }
    </style>
  </head>

  <body>
    <nav id="navbar" class="">
      <?php echo navbar(1, ''); ?>
		  <?php echo loginbar(null, $pdo); ?>
    </nav>

    <main style="margin: 5em 0 2em 0;">
      <h2>En kort analyse av nerders døgnrytme i deres naturlige habitat, PVV</h2>
      <div id="graphDiv">
        <h4>Siste 24 timer</h4>
        <div class="graphbox">
          <canvas id="doorGraphDay"></canvas>
        </div>

        <h4>Siste 7 dager</h4>
        <div class="graphbox">
          <canvas id="doorGraphWeek"></canvas>
        </div>
      </div>
    </main>

    <script
      src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"
      integrity="sha512-WoViKhKD4qI2WruSZqv9+kvM4WfFhUMQCLN4QlDTt5aU56fLQy2gYoxWIqlEnXqJy/+Ac5q/hk1oWfqnMDhwMA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/date-fns@4.4.0/cdn.min.js"
      integrity="sha512-mA7EWmvK4CWPMTbkqGfSNZBMdN9F8+wQGlUqlOxSKv1tJeDKblnuZa7bJkobcg3cnCQ+BrZGX3uenWCFq6cmEA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"
      integrity="sha512-VPUN3sK5Jce8lVuVWfTZolO+BDodUHFq1QsNHmszMbKpYrQzjCxvC0FDG7igWCYBcsFDpqhcVq4sQ851OqhAPg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>

    <script>
      const graphElDay = document.getElementById("doorGraphDay");
      const graphElWeek = document.getElementById("doorGraphWeek");

      const XHR = new XMLHttpRequest();
      const url = "/door/?period=week";
      XHR.open("GET", url);
      XHR.send();

      XHR.onreadystatechange = () => {
        if (XHR.readyState == 4 && XHR.status == 200) {
          console.log("Response 200 from API");
          response = JSON.parse(XHR.responseText); //Should be try-catched?
          if (response.status != "OK") {
            console.log("Error when connecting to API.");
            return;
          } else {
            const allDatapoints = response.entries;
            console.log(
              "Success, " + allDatapoints.length + " datapoints received.",
            );

            const dayDatapoints = getLastDay(allDatapoints);

            displayLineDiagram(graphElDay, dayDatapoints, "hour");
            displayLineDiagram(graphElWeek, allDatapoints, "day");
          }
        }
      };

      function getLastDay(data) {
        let date = new Date();
        let curTime = date.getTime();
        let targetTime = parseInt(curTime / 1e3) - 60 * 60 * 24;

        let i;
        for (i = 0; i < data.length; i++) {
          if (data[i].time < targetTime) {
            break;
          }
        }
        return data.slice(0, i);
      }

      function displayLineDiagram(canv, data, timeunit) {
        let ctx = canv.getContext("2d");
        let dotColor = data.map((entry) =>
          entry.open ? "rgb(10, 150, 10)" : "rgb(200, 100, 100)",
        );

        let chart = new Chart(ctx, {
          type: "line",
          data: {
            labels: data.map((entry) => 1e3 * entry.time),
            datasets: [
              {
                data: data.map((entry) => entry.open),
                stepped: "before",
                segment: {
                  borderColor: (ctx) =>
                    ctx.p0.parsed.y === 1
                      ? "rgb(10, 150, 10)"
                      : "rgb(200, 100, 100)",
                },
                borderColor: dotColor,
                backgroundColor: dotColor,
              },
            ],
          },
          options: {
            scales: {
              x: {
                type: "time",
                display: true,
                time: {
                  unit: timeunit,
                },
                ticks: {
                  display: true,
                  source: "data",
                },
                grid: {
                  display: true,
                },
              },
              y: {
                suggestedMin: -0.1,
                suggestedMax: 1.1,
                grid: { display: false },
                ticks: {
                  callback: (label, index, labels) =>
                    label === 1 ? "Åpent" : label === 0 ? "Stengt" : "",
                },
              },
            },
            plugins: {
              legend: {
                display: false,
              },
              tooltip: {
                callbacks: {
                  label: (tooltipItem) =>
                    tooltipItem.formattedValue === "1" ? "Åpent" : "Stengt",
                },
              },
            },
          },
        });
      }
    </script>
  </body>
</html>
