<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<script src="./includes/jquery.min.js"></script>
		<script src="./includes/d3.v2.min.js"></script>
		<script src="http://23.23.183.118:4000/socket.io/socket.io.js"></script>
		<script src="client.js"></script>
		<script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<script type="text/javascript" src="./includes/smoothie.js"></script>
		<script type='text/javascript'>
			google.load('visualization', '1', {
				packages : ['gauge']
			});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
				var data1 = google.visualization.arrayToDataTable([['Label', 'Value'], ['CPU', 15]]);
				var data2 = google.visualization.arrayToDataTable([['Label', 'Value'], ['Network', 68]]);

				var options = {
					width : 800,
					height : 300,
					redFrom : 90,
					redTo : 100,
					yellowFrom : 75,
					yellowTo : 90,
					minorTicks : 5
				};

				var chart1 = new google.visualization.Gauge(document.getElementById('chart1'));
				var chart2 = new google.visualization.Gauge(document.getElementById('chart2'));
				chart1.draw(data1, options);
				chart2.draw(data2, options);
			}
		</script>
		<title></title>
		<style type="text/css">
			body {
				background-color: black;
				text-align: center;
			}
			h1 {
				color: red;
				font-size: 30px;
			}
			.visitors {
				color: green;
				font-size: 52px;
				font-family: Georgia;
				font-weight: bolder;
			}
			.chart rect {
				font: 10px sans-serif;
				fill: green;
				text-align: right;
				padding: 3px;
				margin: 1px;
				stroke: white;
			}

		</style>

	</head>
	<body>
		<center>
			<h1>Current Number of Visitors</h1>
			<div class="visitors" id="numVisitors"></div>
			<hr />
			<br />
			<table width="50%">
				<tr>
					<td width="25%"><span id='chart1' style="display: inline;"></span></td>
					<td></td>
					<td width="25%"><span id='chart2' style="display: inline;"></span></td>
				</tr>

			</table>
			<br />
			<script>
				var t = 12971163, v = 70, data = d3.range(33).map(next);
				// starting dataset

				function next() {
					return {
						time : ++t,
						value : v = ~~Math.max(10, Math.min(90, v + 10 * (Math.random() - .5)))
					};
				};

				function redraw() {

					var rect = chart.selectAll("rect").data(data, function(d) {
						return d.time;
					});

					rect.enter().insert("rect", "line").attr("x", function(d, i) {
						return x(i + 1) - .5;
					}).attr("y", function(d) {
						return h - y(d.value) - .5;
					}).attr("width", w).attr("height", function(d) {
						return y(d.value);
					}).transition().duration(1000).attr("x", function(d, i) {
						return x(i) - .5;
					});

					rect.transition().duration(1000).attr("x", function(d, i) {
						return x(i) - .5;
					});

					rect.exit().transition().duration(1000).attr("x", function(d, i) {
						return x(i - 1) - .5;
					}).remove();

				}

				setInterval(function() {
					data.shift();
					data.push(next());
					redraw();
					d3.timer.flush();
				}, 1100);

				var w = 20, h = 80;
				var x = d3.scale.linear().domain([0, 1]).range([0, w]);
				var y = d3.scale.linear().domain([0, 100]).rangeRound([0, h]);

				var chart = d3.select("body").append("svg").attr("class", "chart").attr("width", w * data.length - 1).attr("height", h);

				chart.selectAll("rect").data(data).enter().append("rect").attr("x", function(d, i) {
					return x(i) - .5;
				}).attr("y", function(d) {
					return h - y(d.value) - .5;
				}).attr("width", w).attr("height", function(d) {
					return y(d.value);
				});

				chart.append("line").attr("x1", 0).attr("x2", w * data.length).attr("y1", h - .5).attr("y2", h - .5).style("stroke", "#FFF");
				chart.selectAll("text").data(data).enter().append("text").attr("x", x).attr("y", y).attr("dx", -3)// padding-right
				.attr("dy", ".35em")// vertical-align: middle
				.attr("text-anchor", "end")// text-align: right
				.text(String);

			</script>

			<br />
			<br />
			<canvas id="mycanvas" width="400" height="100"></canvas>

		</center>
	</body>
	<script type="text/javascript">
			// Data
		
		var smoothie = new SmoothieChart({
			grid : {
				strokeStyle : 'rgb(125, 0, 0)',
				fillStyle : 'rgb(60, 0, 0)',
				lineWidth : 1,
				millisPerLine : 250,
				verticalSections : 10,
			},
			labels : {
				fillStyle : 'rgb(60, 0, 0)'
			}
		});
		
		var line1 = new TimeSeries();
		var line2 = new TimeSeries();
		
		smoothie.addTimeSeries(line1, {
			strokeStyle : 'rgb(0, 255, 0)',
			fillStyle : 'rgba(0, 255, 0, 0.4)',
			lineWidth : 3
		});
		smoothie.addTimeSeries(line2, {
			strokeStyle : 'rgb(255, 0, 255)',
			fillStyle : 'rgba(255, 0, 255, 0.3)',
			lineWidth : 3
		});
		smoothie.streamTo(document.getElementById("mycanvas"), 1000 /*delay*/);
	

		// Add a random value to each line every second
		setInterval(function() {
			line1.append(new Date().getTime(), Math.random());
			line2.append(new Date().getTime(), Math.random());
		}, 1000);

	</script>
</html>
