<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Edit these codes for each outlet
$codes = array(
    "1" => array(
        "on" => 4281651,
        "off" => 4281660,
        "pulseLength" => 176
    ),
    "2" => array(
        "on" => 4281795,
        "off" => 4281804,
        "pulseLength" => 176
    ),
    "3" => array(
        "on" => 4282115,
        "off" => 4282124,
        "pulseLength" => 176
    ),
    "4" => array(
        "on" => 351491,
        "off" => 351500,
        "pulseLength" => 181
    ),
    "5" => array(
        "on" => 357635,
        "off" => 357644,
        "pulseLength" => 181
    ),
    "6" => array(
        "on" => 357635,
        "off" => 357644,
        "pulseLength" => 181
    ),
);

// Path to the codesend binary (current directory is the default)
$codeSendPath = './codesend';

// This PIN is not the first PIN on the Raspberry Pi GPIO header!
// Consult https://projects.drogon.net/raspberry-pi/wiringpi/pins/
// for more information.
$codeSendPIN = "0";

// Pulse length depends on the RF outlets you are using. Use RFSniffer to see what pulse length your device uses.
$codeSendPulseLength = "176";

if (!file_exists($codeSendPath)) {
    error_log("$codeSendPath is missing, please edit the script", 0);
    die(json_encode(array('success' => false)));
}

$outletLight = $_POST['outletId'];
$outletStatus = $_POST['outletStatus'];

$codesToToggle = array($codes[$outletLight][$outletStatus]);

if ($outletLight <= 3) {
    $codeSendPulseLength = "176";
} else if ($outletLight > 3 && $outletLight < 7) {
    $codeSendPulseLength
}

foreach ($codesToToggle as $codeSendCode) {
    shell_exec($codeSendPath . ' ' . $codeSendCode . ' -p ' . $codeSendPIN . ' -l ' . $codeSendPulseLength);
    sleep(1);
}

die(json_encode(array('success' => true)));
?>
