<?php
// The example will not work unless ob_end_clean() is called
// on top. Strange behaviour! Would like to know a reason
ob_end_clean();

// disable all content encoding as we won't
// be able to calculate the content-length if its enabled
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
header("Content-Encoding: none");


// Tell client that he should close the connection
header("Connection: close");

// keep the script running even if the CLIENT closes the connection
ignore_user_abort(); 

// using ob* functions its easy to content the content-length later
ob_start();

// do your output
echo 'hello world', PHP_EOL;


// get the content length
$size = ob_get_length();
header("Content-Length: $size");

// clear ob* buffers
for ($i = 0; $i < ob_get_level(); $i++) {
    ob_end_flush();
}
flush(); // clear php internal output buffer

// start a time consuming task
sleep(3);


?>