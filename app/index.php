<?php

// import connection to server, classes, and start SESSION 
require_once "../partials/_config.php";

// if user is sign out redirect him to sign in page
if ( !isset( $_SESSION[ "ID" ] ) ) {
    header( "Location: ../index.php" );
}

// import header
include_once "../partials/header-app.php" ?>

    <!-- header with name of user and sign out button -->
    <header class="header">

        <div id="account-header">

            <img src="../assets/img/user.png" alt="user-icon">
            <p><?= $_SESSION[ "firstName" ] . " " . $_SESSION[ "lastName" ] ?></p>

        </div>
        <div class="sign-out-container">

            <img src="../assets/img/sign-out.svg" alt="Sign out" id="sign-out">

        </div>
    </header>

    <!-- navbar -->
    <nav class="nav">

        <ul class="nav-bar">

            <li id="uncomplete-tasks"><img src="../assets/img/uncomplete-task.svg" alt="uncomplete tasks"></li
            >
            <li id="complete-tasks"><img src="../assets/img/complete-task.png" alt="Complete tasks"></li>

        </ul>

        <div class="plus-btn-container">

            <img src="../assets/img/plus.svg" alt="Add Task" id="plus-btn">

        </div>
    </nav>

    <!-- main section with all tasks -->
    <div class="jumbo-container">

        <!-- element for status alerts -->
        <div id="status"></div>

        <!-- uncomplete tasks -->
        <div class="container-collapse-uncomplete">
            <h1 class="sign-h1-blue">Uncomplete Tasks</h1>
            <p class="num-uncomplete-tasks">2</p>
            <div class="white-back">
                <div class="container-collapse">
                    <div class="tasks-contaneir">
                        <?php include_once "../app/alertUncompleteTasks.php" ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- complete tasks -->
        <div class="container-collapse-complete">
            <h1 class="sign-h1-blue">Complete Tasks</h1>
            <p class="num-complete-tasks"></p>
            <div class="white-back">
                <div class="container-collapse">
                    <div class="tasks-contaneir">
                        <?php include_once "../app/alertCompleteTasks.php" ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit section -->
    <div class="jumbo-edit">
        <form action="#" method="post" enctype="multipart/form-data" class="form-ajax">
            <label>Title <p style="opacity: .7;float: right; padding: 0;">Required</p></label>
            <input type="text" name="title" class="input-edit">
            <label>Description</label>
            <textarea rows="" cols="" name="description" class="input-edit">
		</textarea>
            <label>Deadline</label>
            <input type="date" name="date" class="input-edit" style="width: 49%;">
            <input type="time" name="time" class="input-edit" style="width: 48%;">
            <label>Priority</label>
            <select class="input-edit" id="select">
                <option value="rgba(255, 255, 255, 0.8)" selected>None</option>
                <option value="rgba(0, 255, 71, 0.8)">Low</option>
                <option value="rgba(250, 255, 0, 0.8)">Medium</option>
                <option value="rgba(255, 0, 0, 0.7)">High</option>
            </select>
            <label>File <p style="opacity: .7;float: right; padding: 0;">Only .jpeg, .jpg, .png, .txt extension</p>
            </label>
            <input type="file" name="file" class="input-edit">
            <button id="sb-btm" val="add" class="button-edit input-edit">Add</button>
            <button id="cencel" class="button-edit input-edit">Close</button>
        </form>
    </div>

    <!-- import footer -->
<?php include_once "../partials/footer-app.php" ?>