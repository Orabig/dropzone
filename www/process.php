<?php

session_start();

function disable_ob() {
    // Turn off output buffering
    ini_set('output_buffering', 'off');
    // Turn off PHP output compression
    ini_set('zlib.output_compression', false);
    // Implicitly flush the buffer(s)
    ini_set('implicit_flush', true);
    ob_implicit_flush(true);
    // Clear, and turn off output buffering
    while (ob_get_level() > 0) {
        // Get the curent level
        $level = ob_get_level();
        // End the buffering
        ob_end_clean();
        // If the current level has not changed, abort
        if (ob_get_level() == $level) break;
    }
    // Disable apache output buffering/compression
    if (function_exists('apache_setenv')) {
        apache_setenv('no-gzip', '1');
        apache_setenv('dont-vary', '1');
    }
}

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
$file = '/var/www/uploads/'.$filename;

disable_ob(); // This is useful to have the process output realtime
// passthru ('...' . escapeshellarg($file));

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

if ( unlink($file) ) {
	echo "File removed successfully.";
} else {
	echo red("Error removing file !");
}

echo "<br>";

echo "Done.";

?>
