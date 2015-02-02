<?php
function createPie($pValues=""){
	$values = array("2010" => 1950, "2011" => 750, "2012" => 2100, "2013" => 580, "2014" => 5000, "2015" => 5000,"2016" => 5000,"2017" => 5000);
	if(($pValues)){
		$values=$pValues;
	}
	$total = count($values);
	$data = ($total == 0) ? array(360) : array_values($values);
	$keys = ($total == 0) ? array("") : array_keys($values);
	$radius = 30;
	$imgx = 1400 + $radius;
	$imgy = 600 + $radius;
	$cx = 430 + $radius;
	$cy = 200 + $radius;
	$sx = 800;
	$sy = 400;
	$sz = 150;
	$data_sum = array_sum($data);
	$angle_sum = array(-1 => 0, 360);
	$typo = "font/CooperBlackStd.otf";
	$im = imagecreatetruecolor($imgx, $imgy);
	imagesavealpha($im,true);
	$trans_color = imagecolorallocatealpha($im,0,0,0,127);
	imagefill($im,0,0,$trans_color);
	imagecolorallocate($im, 255, 255, 255);
	$color = array(
    array(220, 20, 60),
    array(77, 33, 114),
    array(249, 141, 53),
    array(158, 37, 59),
    array(1, 128, 128),
    array(28, 94, 160),
    array(206, 16, 118),
    array(43, 67, 86),
    array(155, 108, 166),
    array(83, 69, 62)
	);
	shuffle($color);
	shuffle($color);
	shuffle($color);
	$colors = array(imagecolorallocate($im, $color[0][0], $color[0][1], $color[0][2]));
	$colord = array(imagecolorallocate($im, ($color[0][0] / 1.5), ($color[0][1] / 1.5), ($color[0][2] / 1.5)));
	$factorx = array();
	$factory = array();
	for($i = 0; $i < $total; $i++){
		$angle[$i] = (($data[$i] / $data_sum) * 360);
		$angle_sum[$i] = array_sum($angle);
		$colors[$i] = imagecolorallocate($im, $color[$i][0], $color[$i][1], $color[$i][2]);
		$colord[$i] = imagecolorallocate($im, ($color[$i][0] / 1.5), ($color[$i][1] / 1.5), ($color[$i][2] / 1.5));
		$factorx[$i] = cos(deg2rad(($angle_sum[$i - 1] + $angle_sum[$i]) / 2));
		$factory[$i] = sin(deg2rad(($angle_sum[$i - 1] + $angle_sum[$i]) / 2));
	}
	for($z = 1; $z <= $sz; $z++){
		for($i = 0; $i < $total; $i++){
			imagefilledarc($im, $cx + ($factorx[$i] * $radius), (($cy + $sz) - $z) + ($factory[$i] * $radius), $sx, $sy, $angle_sum[$i - 1], $angle_sum[$i], $colord[$i], IMG_ARC_PIE);
		}
	}
	for($i = 0; $i < $total; $i++){
		imagefilledarc($im, $cx + ($factorx[$i] * $radius), $cy + ($factory[$i] * $radius), $sx, $sy, $angle_sum[$i - 1], $angle_sum[$i], $colors[$i], IMG_ARC_PIE);
		imagefilledrectangle($im, 900, 50 + ($i * 30 * 2), 950, 100 + ($i * 30 * 2), $colors[$i]);
		imagettftext($im, 30, 0, 970, 90 + ($i * 30 * 2), imagecolorallocate($im, 0, 0, 0), $typo, $keys[$i]);
		imagettftext($im, 30, 0, $cx + ($factorx[$i] * ($sx / 4)) - 40, $cy + ($factory[$i] * ($sy / 4)) + 10, imagecolorallocate($im, 0, 0, 0), $typo, $data[$i]);
	}
	header('Content-type: image/png');
	
	imagepng($im);
	imagedestroy($im);
}
?>