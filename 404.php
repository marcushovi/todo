<?php

// import connection to server, classes, and start SESSION 
require_once "partials/_config.php";

// import header
include_once "partials/header.php";
?>

    <!-- logo LOST -->
    <div class="logo-container">

        <img src="assets/img/delete.svg" alt="Forbidden" class="logo lost-icon">

    </div>

    <!--  alert 404 not Found and link to backward -->
    <div class="jumbo" style="top: 45%;">

        <div class="form">

            <h1 class="sign-h1">403 Forbidden</h1>

            <p style="color: rgba(0,0,0,0.6);">You do not have permission.</p>

            <p style="color: rgba(0,0,0,0.6);">
                Come
                <a href="index.php" target="_self" style="color: rgba(0, 255, 71, 0.8); text-decoration: underline;">back.</a>
            </p>

        </div>

    </div>
    <script>
        // change text of title
        $( "title" ).text( "404 Not Found" );
    </script>


    <!-- import footer -->
<?php include_once "partials/footer.php"; ?>