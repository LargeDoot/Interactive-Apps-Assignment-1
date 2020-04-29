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

    //Check if an album_id was submitted, if not the redirect to music list page.
    if ( !isset( $_GET[ "track_id" ] ) ) {

        header( "Location: browse.php" );

    }

    //Check that the track exists
    $statement = $connection->prepare( "SELECT * FROM tracks WHERE track_id = ?" );
    $statement->bind_param( "s", $_GET[ "track_id" ] );
    $statement->execute();

    $result = $statement->get_result();
    ////////////////////////////////////

    //If the track doesnt exist then redirect to all tracks page
    if ( mysqli_num_rows( $result ) == 0 ) {

        header( "Location: all-tracks.php" );

    }

    ?>

</head>

<body>

<?php

$trackID = $_GET[ "track_id" ];

//Fetch data for the specified track
$statement = $connection->prepare( "SELECT * FROM tracks WHERE track_id = ?" );
$statement->bind_param( "s", $trackID );
$statement->execute();

$result = $statement->get_result();
$trackData = $result->fetch_assoc();
/////////////////////////////////////////

//Fetch the details of the logged in user for use in reviews
$statement = $connection->prepare( "SELECT * FROM login WHERE username = ?" );
$statement->bind_param( "s", $current_user );
$statement->execute();

$result = $statement->get_result();
$nameData = $result->fetch_assoc();
/////////////////////////////////////////

$name = $nameData[ "name" ];
$user_id = $nameData[ "id" ];

//Code for form submissions
$comment = "";

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

    //Code to deal with the review form submission
    if ( isset( $_POST[ "comment" ] ) ) {

        if ( empty( $_POST[ "comment" ] ) ) {

            $comment = "This user did not leave a comment";

        } else {

            $comment = htmlspecialchars( $_POST[ "comment" ] );

        }

        $rating = htmlspecialchars( $_POST[ "rating" ] );

        //Insert the new review into the reviews table
        $statement = $connection->prepare( "INSERT INTO reviews VALUES(NULL, ?, ?, ?, ?)" );
        $statement->bind_param( "ssss", $trackID, $name, $comment, $rating );
        $statement->execute();
        /////////////////////////////////////////////

    }

    //Code to deal with an add to playlist request
    if ( !empty( $_POST[ "add_playlist" ] ) ) {

        $addPlaylist = htmlspecialchars( $_POST[ "add_playlist" ] );

        //Insert new track into the specified playlist
        $statement = $connection->prepare( "INSERT INTO playlist_entry VALUES(?, ?, ?)" );
        $statement->bind_param( "iii", $addPlaylist, $trackID, $user_id );
        $statement->execute();
        ///////////////////////////////////
    }

}


//Fetch average review
$statement = $connection->prepare( "SELECT AVG(rating) AS 'average' FROM reviews WHERE track_id = ?" );
$statement->bind_param( "s", $trackID );
$statement->execute();

$result = $statement->get_result();
$trackReviewsData = $result->fetch_assoc();
/////////////////////////////////////

$average = $trackReviewsData[ "average" ];

//Fetch reviews again (reusing the query from before)
$statement = $connection->prepare( "SELECT * FROM reviews WHERE track_id = ?" );
$statement->bind_param( "s", $trackID );
$statement->execute();
$result = $statement->get_result();
///////////////////////////////////////////

$numReviews = $result->num_rows;

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

        <h1 class="display-2 my-4"><?php echo( $trackData[ "name" ] ); ?></h1>

        <button type="button" name="play-button" class="btn btn-secondary mx-2"
                data-value="<?php echo( $trackData[ "sample" ] ) ?>">▶
        </button>

        A track by <?php echo( $trackData[ "artist" ] ); ?>

        <br><br>

        <?php
        //Display the average review for the track in stars out of 5

        echo( "Average review: " );

        for ( $i = 0; $i < round( $average / 2 ); $i++ ) {

            echo( "★" );

        }

        for ( $i = 0; $i < ( 5 - round( $average / 2 ) ); $i++ ) {

            echo( "☆" );

        }

        ?>

        <br><br>

        <!-- Form for submitting a review -->
        <form method="post" action="<?php echo( htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) . "?track_id=" .
            $trackID ); ?>">

            <button type="button" class="btn btn-secondary dropdown-toggle float-sm-right"
                    data-toggle="dropdown">
                Add to playlist
            </button>

            <div class="dropdown-menu">

                <?php

                //Fetch available playlists
                $statement = $connection->prepare( "SELECT * FROM playlists WHERE owner_user_id = ?" );
                $statement->bind_param( "i", $user_id );
                $statement->execute();

                $playlistResult = $statement->get_result();
                ///////////////////////////////////////

                //Loop through and create buttons for each playlist
                while ( $playlist = $playlistResult->fetch_assoc() ) {

                    echo( '
                        
                       <button type="submit" name="add_playlist" class="btn btn-secondary dropdown-item"
                            value="' . $playlist[ "playlist_id" ] . '">
                            ' . $playlist[ "playlist_name" ] . '
                       </button>' );

                } ?>

            </div>

        </form>

    </div>

</div>


<div class="container-fluid justify-content-center">

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container w-1200">

        <div class="row mt-5">

            <!-- Column for track info and review input -->
            <div class="col-lg-6 col-md-10">

                <h4>Track description:</h4>

                <p><?php echo( $trackData[ "description" ] ) ?></p>

                <hr>

                <h4>Write a review</h4>

                <form method="post" action="
                <?php echo htmlspecialchars( $_SERVER[ "PHP_SELF" ] . "?track_id=" . $_GET[ "track_id" ] ); ?>">

                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea class="form-control mb-3" rows="3" id="comment" name="comment"></textarea>

                        <div class="row">

                            <div class="col-6">

                                <label style="white-space: nowrap;">Rating:
                                    <select class="form-control mb-3" name="rating">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </label>

                            </div>

                            <div class="col-6">
                                <button type="submit" class="btn btn-secondary float-right my-4">Submit</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <!-- Table for existing reviews -->
            <div class="col-lg-6 col-md-10">

                <table class="table table-hover text-left">

                    <thead>

                    <tr>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php
                    while ( $trackReviewsData = $result->fetch_assoc() ) {

                        echo( '
                                <tr>
                                    <td>' . $trackReviewsData[ "name" ] . '</td>
                                    <td>' . $trackReviewsData[ "rating" ] . '</td>
                                    <td>' . $trackReviewsData[ "review" ] . '</td>
                                </tr>' );

                    } ?>

                    </tbody>

                </table>

                <?php

                if ( $numReviews == 0 ) {

                    echo( 'No one has reviewed this track yet. Why not be the first?' );

                }

                ?>

            </div>

        </div>

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
