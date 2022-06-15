<?php

// import connection to server, classes, and start SESSION 
require_once "partials/_config.php";

// import header
include_once "partials/header.php";
?>

    <!--  alert 404 not Found and link to backward -->
    <div class="jumbo" style="top: 45%;">

        <div class="form">

            <h1 class="sign-h1">500 Internal Server Error</h1>

            <p style="color: rgba(0,0,0,0.6); padding: 1.5em;">There was a problem with the server, but we're working to
                fix it.</p>

        </div>

    </div>
    <script>
        // change text of title
        $( "title" ).text( "404 Not Found" );

    </script>


    <!-- import footer -->
<?php include_once "partials/footer.php"; ?>