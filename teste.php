<?php require 'Mobile_Detect.php';
$detect = new Mobile_Detect();

// Check for any mobile device.
if ($detect->isMobile()) {
    echo "MOBILE";
}else{
    echo "NOT MOBILE";
}
