<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
				<script src="./includes/jquery.min.js"></script>
		<script src="http://23.23.183.118:4000/socket.io/socket.io.js"></script>
		
		
		
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
			h2 {
				color: orange;
				font-size: 28px;
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
			
			<h2 id='loadHeader'></h2>

			<br />
			<br />
			<canvas id="cpuLoad1MinCanvas" width="800" height="200"></canvas> 
			<br />
			<br />
			
		</center>
	</body>
<script type="text/javascript" src="./includes/smoothie.min.js"></script>
		<script src="client.js"></script>	
</html>
