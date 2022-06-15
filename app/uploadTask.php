<?php

// import connection to server, classes, and start SESSION 
require_once "../partials/_config.php";

// check if title is set
if ( !isset( $_POST[ "title" ] ) ) {
    header( "Location: ../index.php" );
}

// array for replace spaces
$r = array( " ", "	" );

// check if title is fill
if ( trim( strlen( str_replace( $r, "", $_POST[ "title" ] ) ) ) > 0 ) {

    // initial variables for form validation and file name
    $validForm = true;
    $validFile = true;
    $file = "none";

    // check if file is set
    if ( isset( $_FILES[ "file" ] ) ) {

        // set variables of file destinations
        $to = "../uploads/" . $_FILES[ "file" ][ "name" ];
        $from = $_FILES[ "file" ][ "tmp_name" ];

        // split file name by dot
        $test = explode( ".", $_FILES[ "file" ][ "name" ] );

        // set name of extension
        $extension = end( $test );
        $fileName = "";

        // create name of file without extension
        for ( $i = 0; $i < count( $test ) - 1; $i++ ) {
            $fileName .= $test[ $i ];
        }

        // if file exists then try to make new name of file
        $z = 2;
        while ( file_exists( $to ) ) {
            $to = "../uploads/" . $fileName . $z . "." . $extension;
            $z++;
        }

        $validFile = $valid->validateFile( $extension );

        if ( $validFile !== true ) {
            echo $validFile;
            $validFile = false;
        }

        // set final name of file for DB
        $file = basename( $to );

    }

    $validForm = $valid->validateTask();

    if ( $validForm !== true ) {
        echo $validForm;
        $validForm = false;
    }


    // check if form is correct
    if ( $validForm && $validFile ) {

        // move file if is set
        if ( isset( $_FILES[ "file" ] ) ) {

            move_uploaded_file( $from, $to );
        }

        // join date and time
        $time = $_POST[ "date" ] . " " . $_POST[ "time" ];

        // if user wants edit task
        if ( $_POST[ "btn" ] == "Edit" ) {

            // if file is not set
            if ( $file === "none" ) {

                $sql = "UPDATE tasks 
			        SET  title = '" . mysqli_real_escape_string( $conn, trim( $_POST[ "title" ] ) )
                    . "',description = '" . mysqli_real_escape_string( $conn, trim( $_POST[ "description" ] ) )
                    . "',deadline = '" . $time
                    . "',  priority = '" . $_POST[ "priority" ]
                    . "',  updatedAt = NOW()
			        WHERE ID = '" . $_POST[ "taskId" ] . "' AND  IdOfUser = '" . $_SESSION[ "ID" ] . "';";
            } // if file is set
            else {

                $sql = "UPDATE tasks 
			        SET  title = '" . mysqli_real_escape_string( $conn, trim( $_POST[ "title" ] ) )
                    . "',description = '" . mysqli_real_escape_string( $conn, trim( $_POST[ "description" ] ) )
                    . "', fileName = '" . $file
                    . "',deadline = '" . $time
                    . "',  priority = '" . $_POST[ "priority" ]
                    . "',  updatedAt = NOW()
			        WHERE ID = '" . $_POST[ "taskId" ] . "' AND  IdOfUser = '" . $_SESSION[ "ID" ] . "';";
            }

        }

        //if user wants add task
        if ( $_POST[ "btn" ] == "Add" ) {
            $complete = 0;
            $sql = "INSERT INTO tasks (IdOfUser, title, description, fileName, deadline, priority, isComplete, createdAt, updatedAt) 
					VALUES ('"
                . $_SESSION[ "ID" ] . "','"
                . mysqli_real_escape_string( $conn, trim( $_POST[ "title" ] ) ) . "','"
                . mysqli_real_escape_string( $conn, trim( $_POST[ "description" ] ) ) . "','"
                . $file . "','"
                . $time . "','"
                . $_POST[ "priority" ] . "' ,'"
                . $complete
                . "', NOW(), NOW() ); ";
        }

        // check status
        if ( $conn->query( $sql ) === TRUE ) {

            if ( $_POST[ "btn" ] == "Add" ) {
                echo "<span class=\"green-span\">Your task was successfully added.</span>";
            }

            if ( $_POST[ "btn" ] == "Edit" ) {
                echo "<span class=\"green-span\">Your task was successfully edited.</span>";
            }
        } else {
            echo "<span class=\"red-span\">Sorry, there was a problem connecting to the server.</span>";
        }

        /*
        * Section below is just for deleting files correctly because when you want edit file of task, the old file of task must be deleted
        * It's something like garbage collector
        */

        // set array with all files on server
        $allFiles = array_diff( scandir( "../uploads" ), array( '..', '.' ) );

        // select all names of files in DB
        $sql = "SELECT fileName FROM tasks";
        $result = $conn->query( $sql );


        if ( $result ) {

            // compare files on server and files from DB
            foreach ( $allFiles as $FileFromDir ) {

                $delete = false;
                while ( $filesFromDB = mysqli_fetch_array( $result ) ) {

                    $filesFromDB[ "fileName" ] = trim( $filesFromDB[ "fileName" ] );
                    $FileFromDir = trim( $FileFromDir );

                    // if file exists on server and in DB then don't delete him
                    if ( $filesFromDB[ "fileName" ] === $FileFromDir ) {

                        $delete = false;
                        break;
                    } // but if doesn't exist in DB then delete him
                    else {
                        $delete = true;
                    }
                }
                // if doesn't exist in DB and exists on server then delete him
                if ( $delete && file_exists( "../uploads/" . $FileFromDir ) ) {
                    unlink( "../uploads/" . $FileFromDir );
                }
            }
        }
    }
} else {
    echo "<span class=\"red-span\">Title is required</span>";
}

?>