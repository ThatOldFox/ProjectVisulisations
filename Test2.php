<?php

    $username = "a9607876_Admin"; 
    $password = "DJNRAJ302";   
    $host = "mysql4.000webhost.com";
    $database="a9607876_302vis";
    
    $server = mysql_connect($host, $username, $password);
    $connection = mysql_select_db($database, $server);
	
	
	$myquery = "SELECT  * FROM  `BMI_cats_adults`";
	
	
    
    $query = mysql_query($myquery);
    
    if ( ! $query ) {
        echo mysql_error();
        die;
    }
    
    $data = array();
    
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
        $data[] = mysql_fetch_assoc($query);
    }		
	
    mysql_close($server);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Basic Bar Chart</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="Styles.css" />
    <style>
    .axis text{
      font-family: Helvetica, Arial, sans-serif;
      font-size: 12px;
      text-anchor: end;
    }
    .axis path{
      fill:none;
      stroke:black;
      stroke-width: 0.5px;
      shape-rendering: crispEdges;
    }
    .bar{
        stroke: none;
        fill: steelblue;
    }
    .textlabel{
        font-family: Helvetica, Arial, sans-serif;
        font-size:14px;
        text-anchor: middle;
		
	
    }
	
	.option{
		font-size: 30px;
	
	} <!--Css class for the option-->
    </style>
	<script src="http://d3js.org/d3.v3.min.js"></script>
</head>

<body>
  <br>
  <div id="wrap">
  
	 <div id="head">
            <div id="maintitle">D3.js Prototype</div>
     </div>
	  <div id="TEST">
	  <optgroup id="optgroup">
	  </optgroup>
	  </div>
	  <div id="div1">
		
	  
		<script>
		<!--Declare array of options -->
		
		var data = ["Underweight", "Normal_weight", "Overweight", "Obese_class_1", "Obese_class_2", "Obese_class_3", "All_obese"];

		<!--select the body of html and append a select boxx to it an load the documents -->
		var select = d3.select('#TEST')<!--Make this name equal the div id you want to place the select box in i used test-->
		.append('select')
		.attr('class','select')
		.on('change',onchange)
			
			
		var options = select
		.selectAll('option')
		.data(data).enter()
		.append('option')
		.text(function (d) { return d; })
		.attr("class", "option"); <!-- made a class that is recognisable by css -->
		
		
		var sex = ["Male", "Female", "All"];
		
		var select = d3.select('#TEST')<!--Make this name equal the div id you want to place the select box in i used test-->
		.append('select')
		.attr('class','gender')
		.on('change',onchange)
			
			
		var options = select
		.selectAll('option')
		.data(sex).enter()
		.append('option')
		.text(function (d) { return d; })
		.attr("class", "option");
		
		
		onchange();		
		<!--on change do this-->
		function onchange() {
				
			<!--clear the div of contents so when a graph changes it loads a new graph -->
			document.getElementById("div1").innerHTML = "";
			
			<!--get the select box value-->
			selectValue = d3.select('select').property('value');
			
			Gender = d3.select('.gender').property('value');
			
			
			var width = 800, height = 500;
			var margin = {top: 20, right: 20, bottom: 30, left: 50};

			//data
			var data = <?php echo json_encode($data)?>;
			
			var temp = new Array();
			for(var i in data){
				 var id = data[i].Gender;
				 
				 if(id == "M" && Gender == "Male")
				 {
					 temp.push(data[i]);
				 }
				 else if(id == "F" && Gender == "Female"){
					 
					 temp.push(data[i]);
				 }
				 else if(Gender == "All"){
					 
					 temp.push(data[i]);
				 }
				 
			}
			
			data = temp;
			

			//x and y Scales
			var xScale = d3.scale.ordinal()
				.rangeRoundBands([0, width], .1);

			var yScale = d3.scale.linear()
				.range([height, 0]);

			xScale.domain(data.map(function(d) { return d.Age_range; }));
			yScale.domain([0, d3.max(data, function(d) { return d[selectValue]; })]);

			//x and y Axes
			var xAxis = d3.svg.axis()
				.scale(xScale)
				.orient("bottom");

			var yAxis = d3.svg.axis()
				.scale(yScale)
				.orient("left");
				

			//create svg container
			var svg = d3.select("#div1")
				.append("svg")
				.attr("width", width + margin.left + margin.right)
				.attr("height", height + margin.top + margin.bottom)
				.append("g")
				.attr("transform", "translate(" + margin.left + "," + margin.top + ")");        

			//create bars
			svg.selectAll(".bar")
				.data(data)
				.enter()
				.append("rect")
				.attr("class", "bar")
				.attr("x", function(d) { return xScale(d.Age_range); })
				.attr("width", xScale.rangeBand())
				.attr("y", function(d) { return yScale(d[selectValue]); })
				.attr("height", function(d) { return height - yScale(d[selectValue]); });

			//drawing the x axis on svg
			svg.append("g")
				.attr("class", "x axis")
				.attr("transform", "translate(0," + height + ")")
				.call(xAxis);

			//drawing the y axis on svg
			svg.append("g")
				.attr("class", "y axis")
				.call(yAxis)
				.append("text")
				.attr("transform", "rotate(-90)")
				.attr("y", -40)
				.attr("dy", ".71em")
				.style("text-anchor", "end")
				.text("People");
				
				console.log(data)
		}
		

					
			</script>
		
		</div>	
		
			
			<!--- Graph 2 -->
		<div id="div2">
			<script>
				//https://bl.ocks.org/mbostock/3887051
				var margin = {top: 20, right: 20, bottom: 30, left: 90},
					width = 850 - margin.left - margin.right,
					height = 500 - margin.top - margin.bottom;

				var x0 = d3.scale.ordinal()
					.rangeRoundBands([0, width], .1);

				var x1 = d3.scale.ordinal();

				var y = d3.scale.linear()
					.range([height, 0]);

				var color = d3.scale.ordinal()
					.range(["#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

				var xAxis = d3.svg.axis()
					.scale(x0)
					.orient("bottom");

				var yAxis = d3.svg.axis()
					.scale(y)
					.orient("left");

				var svg = d3.select("#div2").append("svg")
					.attr("width", width + margin.left + margin.right)
					.attr("height", height + margin.top + margin.bottom)
				  .append("g")
					.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

				d3.csv("children.csv", function(error, data) {
				  if (error) throw error;

				  var ageNames = d3.keys(data[0]).filter(function(key) { return key !== "catagorys"; });

				  data.forEach(function(d) {
					d.ages = ageNames.map(function(name) { return {name: name, value: +d[name]}; });
				  });

				  x0.domain(data.map(function(d) { return d.catagorys; }));
				  x1.domain(ageNames).rangeRoundBands([0, x0.rangeBand()]);
				  y.domain([0, d3.max(data, function(d) { return d3.max(d.ages, function(d) { return d.value; }); })]);

				  svg.append("g")
					  .attr("class", "x axis")
					  .attr("transform", "translate(0," + height + ")")
					  .call(xAxis);

				  svg.append("g")
					  .attr("class", "y axis")
					  .call(yAxis)
					.append("text")
					  .attr("transform", "rotate(-90)")
					  .attr("y", -40)
					  .attr("dy", ".71em")
					  .style("text-anchor", "end")
					  .text("Average People");

				  var state = svg.selectAll(".state")
					  .data(data)
					.enter().append("g")
					  .attr("class", "state")
					  .attr("transform", function(d) { return "translate(" + x0(d.catagorys) + ",0)"; });

				  state.selectAll("rect")
					  .data(function(d) { return d.ages; })
					.enter().append("rect")
					  .attr("width", x1.rangeBand())
					  .attr("x", function(d) { return x1(d.name); })
					  .attr("y", function(d) { return y(d.value); })
					  .attr("height", function(d) { return height - y(d.value); })
					  .style("fill", function(d) { return color(d.name); });

				  var legend = svg.selectAll(".legend")
					  .data(ageNames.slice().reverse())
					.enter().append("g")
					  .attr("class", "legend")
					  .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

				  legend.append("rect")
					  .attr("x", width + 15)
					  .attr("width", 18)
					  .attr("height", 18)
					  .style("fill", color);

				  legend.append("text")
					  .attr("x", width + 10 )
					  .attr("y", 9)
					  .attr("dy", ".35em")
					  .style("text-anchor", "end")
					  .text(function(d) { return d; });
					  
					 

				});
					
		</script>
		</div>
			
		
	</div>
</body>

</html>