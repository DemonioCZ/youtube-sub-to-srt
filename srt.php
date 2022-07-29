<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SRT generator</title>
</head>
<body>
	<form action="/srt.php" method="post">
		<textarea name="text" id="text"></textarea>
		<input type="submit" name="submit">
	</form>
	
<?php

$text=$_POST['text'];
$pocet=substr_count($text, "} ]");
$rozpad=explode("} ]",$text);
for ($o=3; $o <($pocet-1) ; $o++) { 
	$text=$rozpad[$o];
$findme   = "{";
$pos = strpos($text, $findme);
$findme2   = "},";
$pos2 = strpos($text, $findme2);
$konec=$pos2-$pos;
//echo $pos. "-".$pos2;

$newtext=substr($text, $pos, $konec);
//echo $newtext."<br>";

list($i1, $i2, $i3, $i4, $i5, $i6) = explode(": ", $newtext);
$i2=explode(",",$i2);
$i3=explode(",",$i3);
$i5=explode(" }",$i5);

$seconds=(float)$i2[0]/1000;
$secondsK=(float)($i2[0]+$i3[0])/1000;   //opravit na tri desetinne mista
$vypis=$vypis.((float)$o-2)."\r\n";
//echo "pocet:".(int)$pocet."<br>";
$vypis=$vypis.prevod($seconds)." --> ".prevod($secondsK)."\r\n";
$vypis=$vypis.substr($i5[0], 1, strlen($i5[0])-5)."\r\n";

$vypis=$vypis."\r\n";
	// code...
}

echo str_replace("\r\n", "<br>", $vypis);  //show subtitles on screen

/* writes to file*/
$file = "test.srt";
$txt = fopen($file, "w") or die("Unable to open file!");
fwrite($txt, $vypis);
fclose($txt);
/*
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/plain");
readfile($file);*/


function prevod($prom){
$desetiny=explode(".", $prom);
if (strlen($desetiny[1])==2) {
	$desetiny[1]=$desetiny[1]."0";
}
$hours = floor($prom / 3600);
$mins = floor($prom / 60 % 60);
$secs = floor($prom % 60);
return sprintf("%02d", $hours).":".sprintf("%02d", $mins).":".sprintf("%02d", $secs).",".$desetiny[1];
}

?>
</body>
</html>

