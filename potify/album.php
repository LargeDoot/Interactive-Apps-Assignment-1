<!DOCTYPE html>

<!-- Template used from https://www.w3schools.com/bootstrap4/tryit.asp?filename=trybs_template1 -->

<html lang="en">
<head>

    <title>Potify Music</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="custom-theme-colours.css">
    <link rel="stylesheet" href="stylesheet.css">

    <!-- Link to font awesome icon library where all icons used are taken from. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <?php
    require( "db_connection.php" );
    require( "session.php" );

    //Check if an album_id was submitted, if not the redirect to music list page.
    if ( !isset( $_GET[ "album_id" ] ) ) {

        header( "Location: music-list.php" );

    }

    ?>

</head>
<body>

<?php

$albumID = $_GET[ "album_id" ];

$statement = $connection->prepare( "SELECT * FROM album WHERE album_id = ?" );
$statement->bind_param( "s", $albumID );

$statement->execute();

$result = $statement->get_result();

$albumData = $result->fetch_assoc();


$statement = $connection->prepare( "SELECT * FROM tracks WHERE album_id = ?" );
$statement->bind_param( "s", $albumID );

$statement->execute();

$result = $statement->get_result();


?>

<div class="container-fluid">

    <nav class="navbar fixed-top navbar-expand-sm bg-primary navbar-dark">

        <div class="container w-1200">

            <a href="welcome.php" class="navbar-brand">
                <img src="images/Potify_Logo.png" alt="Potify icon">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="collapsibleNavbar">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="music-list.php">Albums</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link border-left px-4 py-0 my-2" href="logout.php">Log out</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>

<div class="container-fluid text-left bg-primary text-white"
     style="padding-top: 10vh; padding-bottom: 10vh">

    <div class="container mx-auto w-1200">

        <div class="row py-4">

            <div class="col-xl-9 col-lg-10">

                <h1 class="display-2"><?php echo( $albumData[ "album_name" ] ); ?></h1>
                <p>An album by <?php echo( $albumData[ "artist" ] ); ?></p>

            </div>

            <div class="col-xl"></div>

        </div>
    </div>
</div>


<div class="container-fluid text-center ">

    <div class="container w-1200">

        <table class="table table-hover text-left">
            <thead class="text-muted">
            <tr>
                <th>Play</th>
                <th>Name</th>
                <th>Rating</th>
            </tr>
            </thead>
            <tbody>
            <?php

            while ( $albumTracks = $result->fetch_assoc() ) {

                echo( '
                <tr>
                    <td>
                    
                    <button type="button" name="play-button" class="btn btn-secondary" 
                    data-value="' . $albumTracks[ "sample" ] . '">▶</button>
                    
                    </td>
                    <td><a href="track.php?track_id=' . $albumTracks[ "track_id" ] . '">' . $albumTracks[ "name" ] . '</a></td>
                    <td>0.00</td>
                </tr>
                ' );

            }

            ?>
            </tbody>
        </table>

    </div>

</div>

<div class="navbar fixed-bottom bg-primary justify-content-center">

    <audio controls id="player" style="width: 80%;">
        <source src="#" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>

</div>

<script>

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
