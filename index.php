<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
				<script src="./includes/jquery.min.js"></script>
		<script src="http://23.23.183.118:4000/socket.io/socket.io.js"></script>
		<script src="client.js"></script>
	
		<script type="text/javascript" src="./includes/smoothie.min.js"></script>
		
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
			strokeStyle : 'rgb(0, 255, 125)',
			fillStyle : 'rgba(0, 255, 125, 0.4)',
			lineWidth : 1
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
