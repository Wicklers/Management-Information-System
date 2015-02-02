<?php // content="text/plain; charset=utf-8"
include ROOT_DIR."includes/jpgraph/jpgraph.php";
include ROOT_DIR."includes/jpgraph/jpgraph_line.php";
include ROOT_DIR."includes/jpgraph/jpgraph_scatter.php";
include ROOT_DIR."includes/jpgraph/jpgraph_regstat.php";
function createSpline($ydata=""){
	$xdata = array( 2,4,6,8,10,12,14,16);
	if(!$ydata){
	$ydata = array(5, 1, 9, 6, 4, 3, 4,2);
	}
	// Get the interpolated values by creating
	// a new Spline object.
	$spline = new Spline($xdata, $ydata);

	// For the new data set we want 40 points to
	// get a smooth curve.
	list($newx, $newy) = $spline -> Get(50);

	// Create the graph
	$g = new Graph(380, 300);
	$g -> SetMargin(30, 20, 40, 30);
	//$g->title->Set("Natural cubic splines");
	//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
	//$g->subtitle->Set('(Control points shown in red)');
	//$g->subtitle->SetColor('darkred');
	$g -> SetMarginColor('lightblue');

	//$g->img->SetAntiAliasing();

	// We need a linlin scale since we provide both
	// x and y coordinates for the data points.
	$g -> SetScale('linlin');
$xlable=array('','AA','AA','AB','AB','BB','BB','BC','BC','CC','CC','CD','CD','DD','DD','FF','FF','');
	// We want 1 decimal for the X-label
	//$g -> xaxis -> SetLabelFormat('%d');
	$g->xaxis->SetTickLabels($xlable);
	// We use a scatterplot to illustrate the original
	// contro points.
	$splot = new ScatterPlot($ydata, $xdata);

	//
	$splot -> mark -> SetFillColor('red@0.3');
	$splot -> mark -> SetColor('red@0.5');

	// And a line plot to stroke the smooth curve we got
	// from the original control points
	$lplot = new LinePlot($newy, $newx);
	$lplot -> SetColor('navy');

	// Add the plots to the graph and stroke
	$g -> Add($lplot);
	$g -> Add($splot);
	$g -> Stroke();
}
?>
