<?php

// import connection to server, classes, and start SESSION 
require_once "partials/_config.php";

// if user is sign in redirect him to app
if ( isset( $_SESSION[ "ID" ] ) ) {
    header( "Location: app/" );
}

// import header
include_once "partials/header.php";

// variable for error messages
$error = array( "email" => "", "pass" => "" );

// check if variables are sets
if ( isset( $_POST[ "email" ] ) && isset( $_POST[ "password" ] ) ) {

    // check validation
    $error[ 'email' ] = $valid->validateEmail( $_POST[ "email" ] );
    $error[ 'pass' ] = $valid->validatePassword( $_POST[ "password" ], $_POST[ "password" ] );

    // if validation is correct
    if ( $error[ 'email' ] === true && $error[ 'pass' ] === true ) {

        // get data of user from DB by mail
        $sql = "SELECT ID, firstName, lastName, email, password FROM user WHERE email = \"" . mysqli_real_escape_string( $conn, $_POST[ "email" ] ) . "\"";

        $result = $conn->query( $sql );

        // check if user exists with this mail
        if ( $result->num_rows > 0 ) {

            $row = $result->fetch_assoc();

            // check if password was correct
            if ( $row[ 'password' ] === hash( "sha256", $_POST[ "password" ] ) ) {

                // save all data of user to SESSION without password
                foreach ( $row as $key => $value ) {

                    if ( $key != "password" ) {
                        $_SESSION[ $key ] = $value;
                    }

                }
                // and redirect user to app
                header( "Location: app/" );
            } // alert wrong password
            else {
                $error[ 'pass' ] = "<span class=\"war\">Wrong password</span>";
            }
        } // alert warning
        else {
            $error[ 'email' ] = "<span class=\"war\">Your account could not be found</span>";
        }
    }

    // delete string "true" from error array becouse string "true" was return value of function
    foreach ( $error as $key => $val ) {
        if ( $val === TRUE ) {
            $error[ $key ] = "";
        }
    }
}
?>

    <!-- Logo container -->
    <div class="logo-container">

        <img src="assets/img/logo.svg" alt="Logo" class="logo">

    </div>

    <!-- form container for sign-in  -->
    <div class="jumbo">

        <div class="form">

            <h1 class="sign-h1">Sign In</h1>

            <form action="index.php" method="post">

                <label>Email <?= $error[ 'email' ] ?></label>
                <input type="text" name="email">

                <label class="passLabel">Password <?= $error[ 'pass' ] ?></label>
                <div class="show-pass"><img src="assets/img/eye-slash-regular.png" alt="" id="show-pass"></div>
                <input type="password" name="password">

                <br>

                <input type="submit" name="submit" value="Submit">

            </form>

            <span class="link">Don't have an account? <a href="register.php" target="_self">Sign up.</a></span>

        </div>

    </div>


    <!-- import footer -->
<?php include_once "partials/footer.php" ?>