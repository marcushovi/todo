$( document ).ready( function () {

    $( ".form-ajax" ).submit( function ( event ) {
        event.preventDefault();
    } );

    // show up status alerts
    $( ".green-span, .red-span" ).css( {
        transform: "translateY(19%)",
        opacity: "1"
    } );

    // delete status alers
    setTimeout( function () {
        $( ".green-span, .red-span" ).fadeOut( 300, function () {
            $( this ).remove();
        } );
    }, 1500 );


    // prints the number of tasks for each container separately
    $( ".num-uncomplete-tasks" ).text( $( ".container-collapse-uncomplete .task" ).length );
    $( ".num-complete-tasks" ).text( $( ".container-collapse-complete .task" ).length );


    // if the name, description, or task file name is longer than is possible for the design, then short them
    var titles = $( ".title" ).not( "#preview .title" );

    titles.each( function () {
        if ( $( this ).text().length > 12 ) {

            var text = $( this ).text().trim();

            var p = $( "<p>" ).addClass( "hidden" ).text( text.substring( 14 ) );


            $( this ).text( text.substring( 0, 12 ) );


            $( this ).append( p );
        }
    } );

    var disc = $( ".description" ).not( "#preview .description" );

    disc.each( function () {
        if ( $( this ).text().length > 21 ) {

            var text = $( this ).text().trim();

            var p = $( "<p>" ).addClass( "hidden" ).text( text.substring( 21 ) );


            $( this ).text( text.substring( 0, 21 ) );


            $( this ).append( p );
        }
    } );

    var file = $( ".filename a" );

    file.each( function () {
        if ( $( this ).text().length > 20 ) {
            var a = $( this ).text().substring( 0, 20 );

            var p = $( "<p>" ).addClass( "hidden" ).text( $( this ).text().substring( 14 ) );


            $( this ).text( a );


            $( this ).append( p );
        }
    } );

    // hide header and navbar
    function clearBars() {
        $( ".header" ).toggleClass( "header-hide" );
        $( ".nav" ).toggleClass( "nav-hide" );
    }

    // scroll up smooth
    function scrollUp() {
        setTimeout( function () {
            $( 'html, body' ).animate( {
                scrollTop: 0
            }, 300 );
        }, 550 );
    }

    // reload tasks for each container separately
    function reloadTasks() {

        setTimeout( function () {
            $.ajax( {
                url: "alertUncompleteTasks.php",
                method: "POST",
                data: "",
                contentType: false,
                cashe: false,
                processData: false,
                success: function ( data ) {
                    // insert tasks
                    $( ".container-collapse-uncomplete .tasks-contaneir" ).html( data );
                }

            } );
        }, 450 );

        setTimeout( function () {
            $.ajax( {
                url: "alertCompleteTasks.php",
                method: "POST",
                data: "",
                contentType: false,
                cashe: false,
                processData: false,
                success: function ( data ) {
                    // insert tasks
                    $( ".container-collapse-complete .tasks-contaneir" ).html( data );
                }

            } );
        }, 450 );
    }

    // show up menu for task
    $( ".expand-container" ).off().click( function () {

        // hide edit section
        $( ".jumbo-edit" ).css( "bottom", "-110%" );

        // show up header and navbar
        $( ".header" ).removeClass( "header-hide" );
        $( ".nav" ).removeClass( "nav-hide" );

        // and show up menu for this task
        var parent = $( this ).parents( ".task" );

        // hide menu for his siblings
        parent.siblings().find( ".expand-menu" ).removeClass( "expand-menu-active" );
        parent.siblings().find( ".expand-container" ).removeClass( "expand-container-active" );

        // and show up menu for this task
        parent.find( ".expand-menu" ).toggleClass( "expand-menu-active" );
        parent.find( ".expand-container" ).toggleClass( "expand-container-active" );

    } );

    // change image when hover this button
    $( ".sign-out-container" ).hover( function () {

        $( "#sign-out" ).attr( "src", "../assets/img/sign-out-classic.svg" );
    }, function () {

        $( "#sign-out" ).attr( "src", "../assets/img/sign-out.svg" );
    } );

    // If you click sign out button, please be sure you are sure
    $( "#sign-out" ).click( function () {

        $( "#alert-sign-out" ).fadeIn( 300 );

        //hide menu and navbar
        clearBars();
    } );

    // if you are sure then redirect to sign-out.php file
    $( "#yes-sign-out" ).click( function () {

        window.location.replace( "sign-out.php" );
    } );

    // if you are not sure then hide alert
    $( "#no-sign-out" ).click( function () {

        $( "#alert-sign-out" ).fadeOut( 300 );

        //show menu and navbar
        clearBars();
    } );


    var taskId = "";
    var parent = "";

    // If you click delete task button, please be sure you are sure
    $( ".delete" ).off().on( "click", function () {

        // hide menu and navbar
        clearBars();

        // save task for next operations
        parent = $( this ).parents( ".task" );

        // show up alert
        $( "#alert-delete-task" ).fadeIn( 300 );

    } );

    // if you are not sure then hide alert
    $( "#no-delete-task" ).off().click( function () {

        // show up menu and navbar
        clearBars();

        // hide alert
        $( "#alert-delete-task" ).fadeOut( 300 );

        // hide menu of task
        parent.find( ".expand-menu" ).toggleClass( "expand-menu-active" );
        parent.find( ".expand-container" ).toggleClass( "expand-container-active" );

    } );

    // if you are sure then delete task
    $( "#yes-delete-task" ).off().click( function () {

        // show up menu and navbar
        clearBars();

        // hide alert
        $( "#alert-delete-task" ).fadeOut( 300 );

        // get number of task ID
        taskId = parent.find( ".task-id" ).text();

        // hide task
        parent.fadeOut( 400 );

        var form = new FormData();

        form.append( "taskId", taskId );

        // send data to server
        $.ajax( {
            url: "deleteTask.php",
            method: "POST",
            data: form,
            contentType: false,
            cashe: false,
            processData: false,
            success: function ( data ) {
                $( "#status" ).html( data );
            }

        } );

        // relaod  all tasks
        reloadTasks();

    } );


    // if you click button edit
    $( ".edit" ).off().on( "click", function () {

        // hide navbar
        $( ".nav" ).toggleClass( "nav-hide" );

        // change value and text of button
        $( "#sb-btm" ).text( "Edit" );
        $( "#sb-btm" ).val( "Edit" );

        // show up edit section
        $( ".jumbo-edit" ).css( "bottom", "0px" );

        // save task for edit
        var parent = $( this ).parents( ".task" );

        // hide menu of this task
        parent.find( ".expand-menu" ).toggleClass( "expand-menu-active" );
        parent.find( ".expand-container" ).toggleClass( "expand-container-active" );

        // save all information of task
        var desc = parent.find( ".description" ).text();

        var title = parent.find( ".title" ).text();

        var prio = parent.css( "background-color" );

        var dateTime = parent.find( ".deadline" ).text().split( " " );

        taskId = parent.find( ".task-id" ).text();

        // and put them into edit section inputs
        $( "input[name='title']" ).val( $.trim( title ) );

        $( "textarea[name='description']" ).val( $.trim( desc ) );

        $( "input[name='date']" ).val( dateTime[ 0 ] );
        $( "input[name='time']" ).val( dateTime[ 1 ] );

        $( "#select" ).val( prio );

        $( "input[name='file']" ).val( "" );
    } );


    // if you want add task
    $( "#plus-btn" ).off().click( function () {

        // hide navbar
        $( ".nav" ).toggleClass( "nav-hide" );

        // hide menu of tasks
        $( ".task" ).find( ".expand-menu" ).removeClass( "expand-menu-active" );
        $( ".task" ).find( ".expand-container" ).removeClass( "expand-container-active" );

        // change value and text of button
        $( "#sb-btm" ).text( "Add" );
        $( "#sb-btm" ).val( "Add" );

        // clear all inputs
        $( "input[name='title']" ).val( "" );
        $( "textarea[name='description']" ).val( "" );

        var now = new Date();
        var day = ("0" + now.getDate()).slice( -2 );
        var month = ("0" + (now.getMonth() + 1)).slice( -2 );
        var currentTime = now.getHours() + ':' + now.getMinutes();
        var currentDate = now.getFullYear() + "-" + (month) + "-" + (day);

        $( "input[name='date']" ).val( currentDate );
        $( "input[name='time']" ).val( currentTime );

        $( "#select" ).val( "rgba(255, 255, 255, 0.8)" );
        $( "input[name='file']" ).val( "" );


        // show edit section (add section)
        $( ".jumbo-edit" ).css( "bottom", "0px" );


    } );

    // change image when hover
    $( "#plus-btn" ).hover( function () {

        $( this ).attr( "src", "../assets/img/plus-classic.svg" );
    }, function () {

        $( this ).attr( "src", "../assets/img/plus.svg" );
    } );

    // if you click add or edit button in edit section
    $( "#sb-btm" ).off().click( function () {

        // scroll up
        scrollUp();

        // if you want add task then go to section of uncomplete tasks
        if ( $( "#sb-btm" ).val() == "Add" ) {
            // show up uncomplte tasks
            $( ".container-collapse-uncomplete" ).removeClass( "container-collapse-uncomplete-active" );
            $( ".container-collapse-complete" ).removeClass( "container-collapse-complete-active" );
        }

        // show up navbar
        $( ".nav" ).toggleClass( "nav-hide" );

        // save all info from edit section
        var title = $( "input[name='title']" ).val();
        var desc = $( "textarea[name='description']" ).val();
        var date = $( "input[name='date']" ).val();
        var time = $( "input[name='time']" ).val();
        var priority = $( "select" ).val();

        var property = $( "input[name='file']" )[ 0 ].files[ 0 ];

        if ( taskId == "" ) {
            taskId = 1;
        }

        var form_data = new FormData();

        form_data.append( "file", property );
        form_data.append( "title", title );
        form_data.append( "description", desc );
        form_data.append( "date", date );
        form_data.append( "time", time );
        form_data.append( "priority", priority );
        form_data.append( "taskId", taskId );
        form_data.append( "btn", $( "#sb-btm" ).val() );


        // send them to the server
        $.ajax( {
            url: "uploadTask.php",
            method: "POST",
            data: form_data,
            contentType: false,
            cashe: false,
            processData: false,
            success: function ( data ) {
                // alert status
                $( "#status" ).html( data );
            }

        } );
        // reload all tasks
        reloadTasks();

        // hide edit section
        $( ".jumbo-edit" ).css( "bottom", "-110%" );
    } );

    // if you want close edit section
    $( "#cencel" ).off().click( function () {

        // hide edit
        $( ".jumbo-edit" ).css( "bottom", "-110%" );

        // show up navbar
        $( ".nav" ).toggleClass( "nav-hide" );
    } );


    // if you want mark task as complete or uncomplete
    $( ".complete" ).off().click( function () {

        // get number of task ID
        taskId = $( this ).parents( ".task" ).find( ".task-id" ).text();

        // hide task
        $( this ).parents( ".task" ).fadeOut( 400 );

        var form = new FormData();

        form.append( "taskId", taskId );

        // send data to server
        $.ajax( {
            url: "uploadUn-CompleteTask.php",
            method: "POST",
            data: form,
            contentType: false,
            cashe: false,
            processData: false,
            success: function ( data ) {
                $( "#status" ).html( data );
            }

        } );

        // relaod all tasks
        reloadTasks();

    } );

    // show up preview alert
    $( ".preview" ).off().click( function () {

        clearBars();

        // save task
        var task = $( this ).parents( ".task" );

        // save preview container
        var preview = $( "#preview-container" );

        // insert title of task to title of preview
        preview.find( ".title" ).text( task.find( ".title" ).text() );

        // insert decsription of task to description of preview
        preview.find( ".description" ).text( task.find( ".description" ).text() );

        // insert deadline of task to deadline of preview
        preview.find( ".deadline" ).text( task.find( ".deadline" ).text() );

        // if task has not image then hide img tag in html
        if ( task.find( ".file-name a" ).attr( "href" ).trim() == "#" ) {
            preview.find( "img" ).hide();
            preview.find( ".pic" ).hide();
        }
        // otherwise show img tag and set path to image
        else {
            preview.find( ".pic" ).show();
            preview.find( "img" ).show();
            preview.find( "img" ).attr( "src", task.find( ".file-name a" ).attr( "href" ) );
        }

        // show up preview alert
        preview.fadeIn( 300 );
    } );

    // hide preview alert
    $( "#preview-cencel" ).off().click( function () {

        // hide preview alert
        $( "#preview-container" ).fadeOut( 300 );

        // show menu and navbar
        clearBars();
    } );

    // show up uncomplete tasks and hide complete tasks
    $( "#uncomplete-tasks" ).off().click( function () {

        // scrol up
        scrollUp();

        // hide menu of tasks
        $( ".task" ).find( ".expand-menu" ).removeClass( "expand-menu-active" );
        $( ".task" ).find( ".expand-container" ).removeClass( "expand-container-active" );

        // show up uncomplete tasks and hide complete tasks
        $( ".container-collapse-uncomplete" ).removeClass( "container-collapse-uncomplete-active" );
        $( ".container-collapse-complete" ).removeClass( "container-collapse-complete-active" );
    } );

    // show up complete tasks and hide uncomplete tasks
    $( "#complete-tasks" ).off().click( function () {

        // scrol up
        scrollUp();

        // hide menu of tasks
        $( ".task" ).find( ".expand-menu" ).removeClass( "expand-menu-active" );
        $( ".task" ).find( ".expand-container" ).removeClass( "expand-container-active" );

        // show up complete tasks and hide uncomplete tasks
        $( ".container-collapse-uncomplete" ).addClass( "container-collapse-uncomplete-active" );
        $( ".container-collapse-complete" ).addClass( "container-collapse-complete-active" );
    } );

    // change image when hover button
    $( "#uncomplete-tasks" ).hover( function () {

        $( this ).children( "img" ).attr( "src", "../assets/img/uncomplete-task-classic.svg" );
    }, function () {

        $( this ).children( "img" ).attr( "src", "../assets/img/uncomplete-task.svg" );
    } );

    // change image when hover button
    $( "#complete-tasks" ).hover( function () {

        $( this ).children( "img" ).attr( "src", "../assets/img/complete-task-classic.svg" );
    }, function () {

        $( this ).children( "img" ).attr( "src", "../assets/img/complete-task.png" );
    } );
} );
