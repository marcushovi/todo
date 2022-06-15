<?php

// import connection to server, classes, and start SESSION 
require_once "partials/_config.php";

// if user is sign in redirect him to app
if ( isset( $_SESSION[ "ID" ] ) ) {
    header( "Location: app/index.php" );
}

// import header
include_once "partials/header.php";

// variable for error messages
$error = array( "Fname" => "", "Lname" => "", "email" => "", "pass" => "", "pass2" => "", "reCaptcha" => "" );

// check if variables are set
if ( isset( $_POST[ "firstName" ] ) && isset( $_POST[ "lastName" ] ) && isset( $_POST[ "email" ] ) && isset( $_POST[ "password" ] ) && isset( $_POST[ "conPassword" ] ) ) {

    // check validation
    $error[ 'Fname' ] = $valid->validateName( $_POST[ "firstName" ] );
    $error[ 'Lname' ] = $valid->validateName( $_POST[ "lastName" ] );
    $error[ 'email' ] = $valid->validateEmail( $_POST[ "email" ] );
    $error[ 'pass' ] = $valid->validatePassword( $_POST[ "password" ], $_POST[ "conPassword" ] );
    $error[ 'pass2' ] = $valid->validatePassword( $_POST[ "conPassword" ], $_POST[ "password" ] );


    // reCaptcha v2
    if ( isset( $_POST[ 'g-recaptcha-response' ] ) ) {
        $captcha = $_POST[ 'g-recaptcha-response' ];
    }
    if ( !$captcha ) {
        $error[ "reCaptcha" ] = "<span class=\"war\">Required</span>";
    }
    $secretKey = "6LfpNwEVAAAAAGzTLLeTDuDoB2Srf-0d4T-uv555";
    $ip = $_SERVER[ 'REMOTE_ADDR' ];
    // post request to server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode( $secretKey ) . '&response=' . urlencode( $captcha );
    $response = file_get_contents( $url );
    $responseKeys = json_decode( $response, true );

    if ( !$responseKeys[ "success" ] && $captcha ) {
        $error[ "reCaptcha" ] = "<span class=\"war\">Stop lying, you're a robot.</span>";
    }


    // if validation is correct and reCaptcha v2 is OK
    if ( $responseKeys[ "success" ] && $error[ 'Fname' ] === true && $error[ 'Lname' ] === true && $error[ 'email' ] === true && $error[ 'pass' ] === true && $error[ 'pass2' ] === true ) {

        // get data of other users and check if mail already exists
        $sql = "SELECT email FROM user WHERE email = \"" . mysqli_real_escape_string( $conn, $_POST[ "email" ] ) . "\"";
        $result = $conn->query( $sql );

        if ( $result->num_rows > 0 ) {

            $error[ 'email' ] = "<span class=\"war\">Account with this email already exists</span>";
        }
        // if email is correct insert user to DB
        if ( $error[ 'email' ] === true ) {

            $sql = "INSERT INTO user (firstName, lastName, email, password, createdAt) VALUES ('" . mysqli_real_escape_string( $conn, $_POST[ "firstName" ] ) . "', '" . mysqli_real_escape_string( $conn, $_POST[ "lastName" ] ) . "', '" . mysqli_real_escape_string( $conn, $_POST[ "email" ] ) . "','" . hash( "sha256", $_POST[ "password" ] ) . "',NOW())";

            // alert status
            if ( $conn->query( $sql ) === TRUE ) {
                echo "<div id=\"ok\" class=\"alert-container\"><div class=\"alert\"><p>You was succsesful registered.</p><span class=\"button\">OK</span></div></div>";
            } else {
                echo "<div id=\"ok\" class=\"alert-container\"><div class=\"alert\"><p>Sorry, there was a problem connecting to the server.</p><span class=\"button\">OK</span></div></div>";
            }
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

    <!-- sign up form -->
    <div class="jumbo signUpForm">

        <div class="form">

            <h1 class="sign-h1">Sign Up</h1>

            <form action="register.php" method="post">

                <label>First Name <?= $error[ 'Fname' ] ?></label>
                <input type="text" name="firstName">

                <label>Last Name <?= $error[ 'Lname' ] ?></label>
                <input type="text" name="lastName">

                <label>Email <?= $error[ 'email' ] ?></label>
                <input type="text" name="email">

                <label class="passLabel">Password <?= $error[ 'pass' ] ?></label>
                <div class="show-pass"><img src="assets/img/eye-slash-regular.png" alt="" id="show-pass"></div>
                <input type="password" name="password" placeholder="">

                <label>Confirm Pass <?= $error[ 'pass2' ] ?></label>
                <input type="password" name="conPassword">

                <br/>

                <label><?= $error[ 'reCaptcha' ] ?></label>
                <div class="g-recaptcha" data-sitekey="6LfpNwEVAAAAACEtPzLt2UwCtwhNw4cjW4xjCnK7"></div>

                <br/>

                <input type="submit" name="submit" value="Submit">
            </form>

            <span class="link">Do you already have account? <a href="index.php" target="_self"> Sign in.</a></span>

        </div>

    </div>

    <!-- change title -->
    <script>
        $( "title" ).text( "Todo Sign Up" );
    </script>
    <!-- import footer -->
<?php include_once "partials/footer.php"; ?>