<?php

// all  validation functions
require_once "validation.php";

// error_reporting(E_ERROR);

// creating path to file ( because this config file is using in more than one directory )
$query = $_SERVER[ 'PHP_SELF' ];
$path = pathinfo( $query );

if ( strpos( $path[ 'dirname' ], "app" ) ) {
    $url = "../assets/json/settings.json";
} else {
    $url = "assets/json/settings.json";
}

// opening json file
$file = file_get_contents( $url );
$appSettings = json_decode( $file );

$servername = $appSettings[ 0 ]->databaseConnection->serverName;
$username = $appSettings[ 0 ]->databaseConnection->userName;
$password = $appSettings[ 0 ]->databaseConnection->password;
$dbname = $appSettings[ 0 ]->databaseConnection->databaseName;

// Create connection
$conn = new mysqli( $servername, $username, $password, $dbname );

// Check connection
if ( $conn->connect_error ) {
    die( include "500.php" );
}


$maxLengthOfName = $appSettings[ 0 ]->UserDataSettings->maxLengthOfName;
$minLengthOfName = $appSettings[ 0 ]->UserDataSettings->minLengthOfName;
$minLengthOfPass = $appSettings[ 0 ]->UserDataSettings->minLengthOfPass;
$maxLengthOfEmail = $appSettings[ 0 ]->UserDataSettings->maxLengthOfEmail;

$maxLengthOfTitle = $appSettings[ 0 ]->TaskDataSettings->maxLengthOfTitle;
$maxLengthOfDescription = $appSettings[ 0 ]->TaskDataSettings->maxLengthOfDescription;
$maxLengthOfPriority = $appSettings[ 0 ]->TaskDataSettings->maxLengthOfPriority;

$maxSizeOfFileKB = $appSettings[ 0 ]->TaskDataSettings->maxSizeOfFileKB;
$maxLengthOfFileName = $appSettings[ 0 ]->TaskDataSettings->maxLengthOfFileName;
$allowedFileExtensions = $appSettings[ 0 ]->TaskDataSettings->allowedFileExtensions;


$valid = new validate( $maxLengthOfName, $minLengthOfName, $minLengthOfPass, $maxLengthOfEmail, $maxLengthOfTitle, $maxLengthOfDescription, $maxLengthOfPriority, $maxSizeOfFileKB, $maxLengthOfFileName, $allowedFileExtensions );


session_start();

?>