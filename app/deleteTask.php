<?php

// import connection to server, classes, and start SESSION 
require_once "../partials/_config.php";


// check if task ID is set
if ( !isset( $_POST[ "taskId" ] ) ) {
    header( "Location: index.php" );
}

// get data about name of file from DB  ,also check user ID
$sql = "SELECT fileName FROM tasks WHERE ID = '" . $_POST[ "taskId" ] . "';";

$result = $conn->query( $sql );

// make path of file
$filePath = "../uploads/" . mysqli_fetch_array( $result )[ "fileName" ];

// delete file if exists
if ( file_exists( $filePath ) ) {
    unlink( $filePath );
}

// delete task from DB
$sql = "DELETE FROM tasks WHERE ID = '" . $_POST[ "taskId" ] . "';";

// alert status
if ( $conn->query( $sql ) === true ) {
    echo "<span class=\"green-span\">Your task was successfully deleted.</span>";
} else {
    echo "<span class=\"red-span\">Sorry, there was a problem connecting to the server.</span>";
}

?>