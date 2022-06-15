</main>

<!-- alert for sign out  -->
<div class="alert-container" id="alert-sign-out">
    <div class="alert">
        <p>Are you sure you want leave?</p>
        <span id="yes-sign-out" class="button">Yes</span>
        <span id="no-sign-out" class="button-white">No</span>
    </div>
</div>

<!-- alert for delete task  -->
<div class="alert-container" id="alert-delete-task">
    <div class="alert">
        <p>Are you sure you want to delete this task?</p>
        <span id="yes-delete-task" class="button">Yes</span>
        <span id="no-delete-task" class="button-white">No</span>
    </div>
</div>

<!-- container for task preview  -->
<div id="preview-container">
    <div id="preview">
        <h1 class="title"></h1>
        <p class="description"></p>
        <p class="deadline"></p>
        <p class="pic">Picture:</p><img alt="picture">
        <button id="preview-cencel" class="button-edit input-edit">Cancel</button>
    </div>
</div>
<script src="../assets/js/jQuery.js"></script>
<script src="../assets/js/app.js"></script>
<script>
    // default settings
    var settings = {

        // settings for button and layer
        position: "fixed", 					// default 'fixed'
        top: "unset",						// default 'unset'
        left: "unset",						// default 'unset'
        bottom: "50px", 						// default '50px'
        right: "50px", 						// default '50px'
        buttonBorderRadius: "22px",						// default '50%'
        transition: "all .5s ease-out", 			// default 'all .5s ease-out'

        // settings for layer
        darkModeBackgroundColor: "#00040E", 					// default '#000'

        // settings for button
        buttonWidth: "3.5em", 					// default '3.5em'
        buttonHeight: "3.5em", 					// default '3.5em'
        buttonText: "🌓",						// default '🌓'
        buttonLineHeight: "3", 						// default '3'
        buttonBorder: "3px solid transparent", 	// default '3px solid transparent'
        buttonHoverBorder: "3px solid #0041FF", 		// default '3px solid #000'
        darkModeButtonHoverBorder: "3px solid #0041FF", 		// default '3px solid #FFF'
        buttonColor: "#00040E", 					// default '#000'
        darkModeButtonColor: "#F0F0F0", 					// default '#000'

        // Settings, where you can set the width of the window where the button will appear (in px)
        minWindowWidth: "1000",						// default '0'

        // event listener function
        event: "click"                      // default 'click'
    };

    // function which execute when you dark mode button
    function darkModeIsActivated() {

        $( ".sign-h1-blue" ).toggleClass( "sign-h1" );

        $( ".num-complete-tasks, .num-uncomplete-tasks" ).toggleClass( "num-tasks-active" );
    }

</script>
<script src="../assets/js/darkMode.min.js" defer></script>
</body>
</html>
