$( document ).ready( function () {

    // redirect to the main page after registration
    $( "#ok" ).click( function () {
        window.location.replace( "index.php" );

        $( "#ok" ).remove();
    } );

    // icon to show password in inputs
    var showPass = $( "#show-pass" );

    showPass.mousedown( function () {
        showPass.attr( "src", "assets/img/eye-regular.png" );
        $( "input[name='password']" ).attr( "type", "text" );
        $( "input[name='conPassword']" ).attr( "type", "text" );
    } );

    showPass.mouseup( function () {
        showPass.attr( "src", "assets/img/eye-slash-regular.png" );
        $( "input[name='password']" ).attr( "type", "password" );
        $( "input[name='conPassword']" ).attr( "type", "password" );

    } );

    showPass.mouseleave( function () {
        showPass.attr( "src", "assets/img/eye-slash-regular.png" );
        $( "input[name='password']" ).attr( "type", "password" );
        $( "input[name='conPassword']" ).attr( "type", "password" );

    } );

} );



