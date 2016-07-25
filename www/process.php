<?php

session_start();

function flush_buffers(){
    ob_end_flush(); 
    ob_flush(); 
    flush(); 
    ob_start(); 
}

function red($html) {
	return "<font color='#F88'>" . $html . "</font>";
}


$filename = $_GET['filename'];
// TODO : escape unwanted chars
$file = '/var/www/uploads/'.$filename;

echo "Processing '$filename' ...";
echo "<br>";flush_buffers();

// Simulates long processing...

echo "Step 1/2 ";
$i=0;
while ($i++<5) {
	echo ".";flush_buffers();
	usleep(1000000);
}
echo "<br>";

echo red("Step 2/2 ");
$i=0;
while ($i++<5) {
	echo ".";flush_buffers();
	usleep(1000000);
}
echo "<br>";



if (unlink($file)) {
	echo "File removed successfully.";
} else {
	echo red("Error removing file !");
}

echo "<br>";

echo "Done.";

?>
