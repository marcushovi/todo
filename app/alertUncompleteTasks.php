<?php

// import connection to server, classes, and start SESSION 
require_once "../partials/_config.php";

// get all uncomplete tasks sorted by time when were created ,also check user ID
$sql = "SELECT ID, title, description, fileName, deadline, priority FROM tasks WHERE idOfUser = " . $_SESSION[ "ID" ] . " AND isComplete = 0 ORDER BY createdAt DESC ;";

$result = $conn->query( $sql );


?>
<!-- import script for alert tasks because web site will be not refresh -->
<script src="../assets/js/app.js"></script>

<?php
// check if user have some tasks
if ( $result && $result->num_rows > 0 ) {

    //  alert tasks separately
    while ( $row = mysqli_fetch_array( $result ) ) {

        ?>

        <!-- task container -->
        <div class="task" style="background: <?= $row[ "priority" ] ?>;">

            <!-- title with expand button and menu for task  -->
            <div class="title-container">

                <h1 class="title"><?= $row[ "title" ] ?></h1>

                <div class="expand-container">
                    <div class="expand-btn"></div>
                </div>

                <ul class="expand-menu">
                    <li class="delete"><img src="../assets/img/delete.svg" alt="Delete Button" class="delete-btn">
                        <p>Delete</p>
                    </li
                    >
                    <li class="complete"><img src="../assets/img/complete.svg" alt="Complete Button"
                                              class="complete-btn">
                        <p>Complete</p>
                    </li
                    >
                    <li class="edit"><img src="../assets/img/edit.svg" alt="Edit Button" class="edit-btn">
                        <p>Edit</p>
                    </li
                    >
                    <li class="preview"><img src="../assets/img/preview.svg" alt="Preview Button" class="show-btn">
                        <p>Preview</p>
                    </li>
                </ul>

            </div>

            <!--  description -->
            <p class="description">
                <?= $row[ "description" ] ?>
            </p>

            <!-- ID of task, deadline, name of file -->
            <div class="status">

                <p class="task-id"><?= $row[ "ID" ] ?></p>

                <p class="file-name">
                    <a href="
				    <?php
                    // if task has not file
                    if ( $row[ "fileName" ] == "none" ) {
                        echo "#";
                    } // else insert path of file
                    else {
                        echo "../uploads/" . $row[ "fileName" ];
                    }
                    ?> " target="_blank">

                        <?php
                        // if task has file
                        if ( $row[ "fileName" ] != "none" ) {
                            echo $row[ "fileName" ];
                        }
                        ?>

                    </a>
                </p>

                <p class="deadline"><?= substr( $row[ "deadline" ], 0, -3 ) ?></p>

            </div>
        </div>

        <?php
    }
} // then alert "You have no tasks yet"
else {
    echo "<p style=\"width:100%; padding-top: 3em; color: #FFF; opacity: .5; text-align: center;\">You have no tasks yet.</p>";
}


?>
			
				