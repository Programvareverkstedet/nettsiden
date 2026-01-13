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
    </style>
  </head>

  <body>
    <nav id="navbar" class="">
      <?php echo navbar(1, 'galleri'); ?>
		  <?php echo loginbar(null, $pdo); ?>
    </nav>

    <main style="margin: 5em 0 2em 0;">
      <h2>En kort analyse av nerders døgnrytme i deres naturlige habitat, PVV</h2>
      <div id="graphDiv">
        <h4>Siste 24 timer</h4>
        <div style="margin: 20px;">
          <canvas id="doorGraphDay"></canvas>
        </div>

        <h4>Siste 7 dager</h4>
        <div style="margin: 20px;">
          <canvas id="doorGraphWeek"></canvas>
        </div>
      </div>
    </main>

    <script
      src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"
      integrity="sha384-jb8JQMbMoBUzgWatfe6COACi2ljcDdZQ2OxczGA3bGNeWe+6DChMTBJemed7ZnvJ"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"
      integrity="sha384-+EEFFjsGn4BnW70Nv0OvoMe1VZuqS4xvx90V2MTeuYUUZSEabg7FSMWl6s2DJTAO"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.1/dist/chartjs-adapter-moment.min.js"
      integrity="sha384-s5cwu7c1MxOfC90RGRDWeB53/7VpDTxXi0YxKJF5y9oKA99+UYxMk0qvlqso188s"
      crossorigin="anonymous"
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

      // https://www.chartjs.org/docs/latest/configuration/canvas-background.html
      const bgColorPlugin = {
        id: "bgColorPlugin",
        beforeDraw: (chart, args, options) => {
          const { ctx } = chart;
          ctx.save();
          ctx.globalCompositeOperation = "destination-over";
          ctx.fillStyle = options.color || "#99ffff";
          ctx.fillRect(0, 0, chart.width, chart.height);
          ctx.restore();
        },
      };

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
              bgColorPlugin: {
                color: "#EEEEEE",
              },
            },
          },
          plugins: [bgColorPlugin],
        });
      }
    </script>
  </body>
</html>
