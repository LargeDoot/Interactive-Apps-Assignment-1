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

    //Check if an search query was submitted, if not the redirect to search page.
    if ( !isset( $_GET[ "query" ] ) ) {

        header( "Location: search.php" );

    }

    ?>

</head>

<body>

<?php

$query = $_GET[ "query" ];
$sql_query = "%" . $query . "%";

//Get albums and push into an array to make it easier to display later on
$statement = $connection->prepare( "SELECT * FROM album" );
$statement->execute();

$result = $statement->get_result();
///////////////////////////////////

$albumList = array();

while ( $value = $result->fetch_assoc() ) {

    array_push( $albumList, $value );

}

//Fetch tracks that fit the search criteria
$searchStatement = "SELECT tracks.* FROM tracks JOIN album ON tracks.album_id=album.album_id WHERE tracks.name LIKE ? OR tracks.artist LIKE ? OR album.album_name LIKE ? GROUP BY track_id";

$statement = $connection->prepare( $searchStatement );
$statement->bind_param( "sss", $sql_query, $sql_query, $sql_query );
$statement->execute();

$result = $statement->get_result();
///////////////////////////////////////////

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

        <h1 class="display-2 my-4">Search Results</h1>
        <p>for '<?php echo( $query ); ?>'</p>

    </div>

</div>


<!-- Main page content -->
<div class="container-fluid text-center ">

    <div class="container w-1200 overflow-auto">

        <div class="table-responsive">

            <!-- Table to hold all tracks that fit search -->
            <table class="table table-hover text-left">

                <thead class="text-muted">

                <tr>
                    <th>Play</th>
                    <th>Name</th>
                    <th>Artist</th>
                    <th class="d-none d-sm-table-cell">Album</th>
                    <th>Rating</th>
                </tr>

                </thead>

                <tbody>

                <?php

                //Loop through and display tracks that fit the search with their average rating
                while ( $tracks = $result->fetch_assoc() ) {

                    //Fetch the average rating for the current track
                    $statement = $connection->prepare( "SELECT AVG(rating) AS 'average' FROM reviews WHERE track_id = ?" );
                    $statement->bind_param( "s", $tracks[ "track_id" ] );
                    $statement->execute();

                    $reviewsResult = $statement->get_result();
                    $avg = $reviewsResult->fetch_assoc();
                    /////////////////////////////////////////////

                    //Display the track in a row
                    echo( '
                <tr>
                    <td>
                    
                    <button type="button" name="play-button" class="btn btn-secondary" 
                    data-value="' . $tracks[ "sample" ] . '">▶</button>
                    
                    </td>
                    <td><a href="track.php?track_id=' . $tracks[ "track_id" ] . '">' . $tracks[ "name" ] . '</a></td>
                    <td><a href="track.php?artist=' . urlencode( $tracks[ "artist" ] ) . '">' . $tracks[ "artist" ] . '</a></td>
                    <td class="d-none d-sm-table-cell"><a href="track.php?track_id=' . $tracks[ "album_id" ] . '">' . $albumList[ $tracks[ "album_id" ] - 1 ][ "album_name" ] . '</a></td>
                    <td>' . number_format( $avg[ "average" ], 2 ) . '</td>
                </tr>' );

                } ?>

                </tbody>

            </table>

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
