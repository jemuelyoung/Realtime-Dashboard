<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<script src="./includes/jquery.min.js"></script>
		<script src="http://23.23.183.118:4000/socket.io/socket.io.js"></script>

		<title>Dashboard</title>
		<style type="text/css">
			body {
				background-color: gray;
				text-align: center;
				margin: 50px 0px;
				padding: 0px;
			}
			h1 {
				color: orange;
				font-size: 30px;
			}
			h2 {
				font-size: 28px;
				display: inline;
			}
			.legend_title {
				color: white;
				font-size: 25px;
				width: 40px;
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
			.fill_legend {
				height: 20px;
				width: 20px;
				display: inline-block;
				margin-right: 5px;
			}
			.fill_server_status_online{
				color: #FFFFFF;
				background-color: green;
				text-align: center;
				height: 20px;
				width: 65px;
				display: inline-block;
				margin-right: 5px;
				
			}
			.content {
				width: 980px;
				margin: 0px auto;
				text-align: left;
				padding: 15px;
			}
			
			td.center_33 {
				text-align: center;
				width: 33%;
			}

		</style>

	</head>
	<body>

		<h1>Current Number of Visitors</h1>
		<div class="visitors" id="numVisitors"></div>
		<hr />
		<br />

		<br />
		<br />
		<table class="content">
			<tr>
			<th align="center">Server #1 Status</th>
			<th align="center">Server #2 Status</th>
			<th align="center">Server #3 Status</th>
				
			</tr>
			<tr>
				<td class="center_33">
					<div id="ss_1" class="fill_server_status_online">ONLINE</div>
				</td>
				<td class="center_33">
					<div id="ss_2" class="fill_server_status_online">ONLINE</div>
				</td>
				<td class="center_33">
					<div id="ss_3" class="fill_server_status_online">ONLINE</div>
				</td>
			
			</tr>
			<tr>
				<td>
				<br /></td>
			</tr>
			<tr>
				<td>
				<br /></td>
			</tr>
			<tr>
				<td>
				<br /></td>
			</tr>
		
			<tr>
				<td class="center_33"><span class="legend_title">Legend:&nbsp;</span></td>
				<td class="center_33"><div class="fill_legend" style="background-color: rgb(0, 255, 125);"></div>CPU Load Average 1 minute</td>
				<td class="center_33"><div class="fill_legend" style="background-color: rgb(255, 50, 0);"></div>CPU Load Average 5 minute</td>
				<td style="padding-left: 50px;"></td>
			</tr>
			<tr>
				<th></th>
				<td class="center_33"><h2 id='load1Header'></h2></td>
				<td class="center_33"><h2 id='load2Header'></h2></td>
			</tr>
			<tr>
				<td style="text-align: center;" colspan="3"><canvas id="cpuLoad1MinCanvas" width="980" height="200"></canvas></td>
			</tr>
			
		</table>
		

		<br />
		<br />

	</body>
	<script type="text/javascript" src="./includes/smoothie.min.js"></script>
	<script src="client.js"></script>
</html>
