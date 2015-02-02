<?php // content="text/plain; charset=utf-8"
require_once (ROOT_DIR .'includes/jpgraph/jpgraph.php');
require_once (ROOT_DIR .'includes/jpgraph/jpgraph_pie.php');
require_once (ROOT_DIR .'includes/jpgraph/jpgraph_pie3d.php');

function createPie3D($pValues = "") {
	// Some data
	$values = array("2010" => 1950, "2011" => 750, "2012" => 2100, "2013" => 580, "2014" => 5000, "2015" => 5000, "2016" => 5000, "2017" => 5000);
	if(($pValues)){
		$values=$pValues;
	}
	$total = count($values);
	$data = ($total == 0) ? array(360) : array_values($values);
	$keys = ($total == 0) ? array("") : array_keys($values);
	// Create the Pie Graph.
	$graph = new PieGraph(380, 400);

	$theme_class = new VividTheme;
	$graph -> SetTheme($theme_class);

	// Set A title for the plot
	//$graph->title->Set("A Simple 3D Pie Plot");

	// Create
	$p1 = new PiePlot3D($data);
	$p1 -> SetLegends($keys);
	$graph -> Add($p1);

	$p1 -> ShowBorder();
	$p1 -> SetColor('black');
	$p1 -> ExplodeSlice(1);
	$graph -> Stroke();

}
?>