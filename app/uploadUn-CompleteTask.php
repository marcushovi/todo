<?php

// import connection to server, classes, and start SESSION 
require_once "../partials/_config.php";

// get data of task , if task is complte or not ,also check user ID
$sql = "SELECT isComplete FROM tasks WHERE ID = '" . $_POST[ "taskId" ] . "' AND  IdOfUser = '" . $_SESSION[ "ID" ] . "';";

$result = $conn->query( $sql );

// if is complete change to uncomplte
if ( $conn->query( $sql ) && mysqli_fetch_array( $result )[ "isComplete" ] == "1" ) {
    $complete = "0";
} // otherwise change to complete
else {
    $complete = "1";
}

// update this task ,also check user ID
$sql = "UPDATE tasks SET isComplete = '" . $complete . "' WHERE ID = '" . $_POST[ "taskId" ] . "' AND  IdOfUser = '" . $_SESSION[ "ID" ] . "';";

$result = $conn->query( $sql );

// alert status
if ( $conn->query( $sql ) === TRUE ) {
    echo "<span class=\"green-span\">Your task was successfully edited.</span>";
} else {
    echo "<span class=\"red-span\">Sorry, there was a problem connecting to the server.</span>";
}

?>