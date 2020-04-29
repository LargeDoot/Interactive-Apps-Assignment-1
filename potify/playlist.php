<!DOCTYPE html>

<!-- Template used from https://www.w3schools.com/bootstrap4/tryit.asp?filename=trybs_template1 -->
<!-- The Bootstrap 4 framework was used for this site - see https://getbootstrap.com/ for more details -->

<html lang="en">
<head>

    <title>Potify Music</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Link to Bootstrap and custom stylesheets (Bootstrap via CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="custom-theme-colours.css">
    <link rel="stylesheet" href="stylesheet.css">

    <!-- Link to font awesome icon library where all icons used are taken from. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Link to jQuery and Boostrap javascript files via CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <?php
    //Page requires a successful database connection and valid session
    require( "db_connection.php" );
    require( "session.php" );

    //Check if an playlist_id was submitted, if not the redirect to music list page.
    if ( !isset( $_GET[ "playlist_id" ] ) ) {

        header( "Location: playlists.php" );

    }

    //Fetch the user ID from the username provided by session variable
    $statement = $connection->prepare( "SELECT id FROM login WHERE username = ?" );
    $statement->bind_param( "s", $current_user );
    $statement->execute();

    $result = $statement->get_result();
    $user_id = $result->fetch_assoc();
    ///////////////////////////////////////

    //Fetch the owner ID of the specified playlist for use in verifying ownership
    $statement = $connection->prepare( "SELECT owner_user_id FROM playlists WHERE playlist_id = ?" );
    $statement->bind_param( "i", $_GET[ "playlist_id" ] );
    $statement->execute();

    $result = $statement->get_result();
    $owner_user_id = $result->fetch_assoc();
    /////////////////////////////////////////

    //Check that the requested playlist is owned by the logged in user, if not the redirect
    if ( !( $user_id[ "id" ] == $owner_user_id[ "owner_user_id" ] ) ) {

        header( "Location: playlists.php" );

    }

    ?>

</head>
<body>

<?php

$playlist_id = $_GET[ "playlist_id" ];

//If a form was submitted
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

    //Code to handle removing a song from the playlist
    if ( !empty( $_POST[ "remove_song" ] ) ) {

        $removeSong = htmlspecialchars( $_POST[ "remove_song" ] );

        //Remove song from playlist
        $statement = $connection->prepare( "DELETE FROM playlist_entry WHERE playlist_id = ? AND track_id = ?" );
        $statement->bind_param( "ii", $playlist_id, $removeSong );
        $statement->execute();
        ///////////////////////////////

    } //Code to handle deleting the playlist
    elseif ( !empty( $_POST[ "delete" ] ) ) {

        //Delete all playlist entries associated with current playlist
        $statement = $connection->prepare( "DELETE FROM playlist_entry WHERE playlist_id = ?" );
        $statement->bind_param( "i", $playlist_id );
        $statement->execute();
        ///////////////////////////////////

        //Delete the playlist
        $statement = $connection->prepare( "DELETE FROM playlists WHERE playlist_id = ?" );
        $statement->bind_param( "i", $playlist_id );
        $statement->execute();
        ///////////////////////////////////

        //Redirect
        header( "Location: playlists.php" );

    }

    //Code to deal with an add to playlist request
    if ( !empty( $_POST[ "add_playlist" ] ) ) {

        $addPlaylist = htmlspecialchars( $_POST[ "add_playlist" ] );

        //Add the song to the playlist
        $statement = $connection->prepare( "INSERT INTO playlist_entry VALUES(?, ?, ?)" );
        $statement->bind_param( "iii", $playlist_id, $addPlaylist, $user_id );
        $statement->execute();
        /////////////////////////////////
    }

}

//Get the playlist information
$statement = $connection->prepare( "SELECT * FROM playlists WHERE playlist_id = ?" );
$statement->bind_param( "s", $playlist_id );
$statement->execute();

$result = $statement->get_result();
$playlistData = $result->fetch_assoc();
//////////////////////////////////

//Fetch all tracks data where it is in the playlist
$statement = $connection->prepare( "SELECT tracks.* FROM tracks, playlist_entry WHERE tracks.track_id = playlist_entry.track_id AND playlist_entry.playlist_id = ?" );
$statement->bind_param( "i", $playlist_id );
$statement->execute();

$result = $statement->get_result();
/////////////////////////////////////


?>

<div class="container-fluid">

    <!-- Navigation bar -->
    <nav class="navbar fixed-top navbar-expand-sm bg-primary navbar-dark">

        <!-- Max width container to keep content centered on a wide screen -->
        <div class="container w-1200">

            <a href="welcome.php" class="navbar-brand">
                <img src="images/Potify_Logo.png" alt="Potify icon">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar items -->
            <div class="navbar-collapse collapse" id="collapsibleNavbar">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="all-tracks.php">All Tracks</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="playlists.php">Playlists</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="browse.php">Browse</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="search.php">Search</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link border-left px-4 py-0 my-2" href="logout.php">Log out</a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

</div>

<div class="container-fluid text-left bg-primary text-white" style="padding-top: 10vh; padding-bottom: 10vh">

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container mx-auto w-1200">

        <h1 class="display-2 my-4"><?php echo( $playlistData[ "playlist_name" ] ); ?></h1>
        <p>A playlist by you!</p>

        <!-- Delete playlist button -->
        <form method="post" action="<?php echo( htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) . "?playlist_id=" .
            $playlist_id ); ?>">

            <button type="submit" name="delete" class="btn btn-secondary float-sm-right"
                    value="<?php echo( $playlist_id ); ?>">
                Delete playlist
            </button>

        </form>

    </div>

</div>


<!-- Main page content -->
<div class="container-fluid text-center ">

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container w-1200">

        <table class="table table-hover text-left">

            <thead class="text-muted">

            <tr>
                <th>Play</th>
                <th>Name</th>
                <th>Rating</th>
                <th>Remove</th>
            </tr>

            </thead>

            <tbody>

            <?php

            //Loop through the tracks and display them in table rows
            while ( $tracks = $result->fetch_assoc() ) {

                //Fetch average rating for the current track
                $statement = $connection->prepare( "SELECT AVG(rating) AS 'average' FROM reviews WHERE track_id = ?" );
                $statement->bind_param( "s", $tracks[ "track_id" ] );
                $statement->execute();

                $reviewsResult = $statement->get_result();
                $avg = $reviewsResult->fetch_assoc();
                ////////////////////////////////////////////

                //Display the current track in a row
                echo( '
                <tr>
                    <td>
                    
                    <button type="button" name="play-button" class="btn btn-secondary" 
                    data-value="' . $tracks[ "sample" ] . '">▶</button>
                    
                    </td>
                    <td><a href="track.php?track_id=' . $tracks[ "track_id" ] . '">' . $tracks[ "name" ] . '</a></td>
                    <td>' . number_format( $avg[ "average" ], 2 ) . '</td>
                    <td class="fit">
                    
                        <form method="post" action="' . htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) . "?playlist_id=" .
                    $playlist_id . '">
                        
                            <button type="submit" name="remove_song" class="btn btn-secondary dropdown-item"
                                value="' . $tracks[ "track_id" ] . '">	&#10060; </button>
                                
                        </form>
                    
                    </td>
                </tr>' );

            } ?>

            </tbody>

        </table>


        <!-- Table to show 5 random song that the user can quickly add to their playlist -->
        <div class="display-4 mt-5 text-left">Random Songs</div>
        <div class="text-left mb-2">Why not discover some new songs?</div>

        <table class="table table-hover text-left">
            <tbody>

            <?php

            //Fetch 5 random tracks
            $statement = $connection->prepare( "SELECT * FROM tracks ORDER BY RAND() LIMIT 5" );
            $statement->execute();

            $randomTracks = $statement->get_result();
            ////////////////////////////////

            //Loop through the random tracks and display them with average ratings
            while ( $tracks = $randomTracks->fetch_assoc() ) {

                //Fetch average rating for the current track
                $statement = $connection->prepare( "SELECT AVG(rating) AS 'average' FROM reviews WHERE track_id = ?" );
                $statement->bind_param( "s", $tracks[ "track_id" ] );
                $statement->execute();

                $reviewsResult = $statement->get_result();
                $avg = $reviewsResult->fetch_assoc();
                ////////////////////////////////////////////////

                //Display the row
                echo( '
                <tr>
                    <td>
                    
                    <button type="button" name="play-button" class="btn btn-secondary" 
                    data-value="' . $tracks[ "sample" ] . '">▶</button>
                    
                    </td>
                    <td><a href="track.php?track_id=' . $tracks[ "track_id" ] . '">' . $tracks[ "name" ] . '</a></td>
                    <td></td>
                    <td>' . number_format( $avg[ "average" ], 2 ) . '</td>
                    <td class="fit">
                    
                        <form method="post" action="' . htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) . "?playlist_id=" .
                    $playlist_id . '">
                        
                            <button type="submit" name="add_playlist" class="btn btn-secondary"
                                value="' . $tracks[ "track_id" ] . '">
                                +
                           </button>
                                
                        </form>
                    
                    </td>
                </tr>' );

            } ?>

            </tbody>

        </table>

    </div>

</div>

<!-- Audio player -->
<div class="navbar fixed-bottom bg-primary justify-content-center">

    <audio controls id="player" style="width: 80%;">
        <source src="#" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>

</div>

<script>

    // Code to deal with audio player sources

    let playButtonArray = document.getElementsByName("play-button");
    let player = document.getElementById("player");

    playButtonArray.forEach(function (element) {

        element.addEventListener("click", function () {

            player.setAttribute("src", element.getAttribute("data-value"));
            player.play();

        });

    });

</script>

</body>
</html>
