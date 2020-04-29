<!DOCTYPE html>

<!-- Template used from https://www.w3schools.com/bootstrap4/tryit.asp?filename=trybs_template1 -->
<!-- The Bootstrap 4 framework was used for this site - see https://getbootstrap.com/ for more details -->
<!-- Slick carousel used from https://github.com/kenwheeler/slick -->

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


    <!-- Import the slick slider styles -->
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

    <!-- Link to jQuery and Boostrap javascript files via CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <?php
    //Page requires a successful database connection and valid session
    require( "db_connection.php" );
    require( "session.php" );
    ?>

</head>

<body>

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
                        <a class="nav-link px-4 active" href="browse.php">Browse</a>
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

        <h1 class="display-2 my-4">Our Music</h1>
        <p>Browse all our music here</p>

    </div>

</div>


<!-- Main page content -->
<div class="container-fluid text-center ">

    <!-- Display all albums -->
    <div class="display-4 my-4">By Album</div>

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container w-1200">

        <div class="slick-carousel">

            <?php

            //Fetch all albums to display on cards in a slider
            $statement = $connection->prepare( "SELECT * FROM album;" );
            $statement->execute();

            $result = $statement->get_result();
            ///////////////////////////////////////////////////

            //Loop through the albums and display them each as a card
            while ( $row = mysqli_fetch_assoc( $result ) ) {


                echo( '                  
                    <div class="card m-3 border-0 underline-hover" style="max-width: 16rem;">
        
                        <img class="card-img-top rounded" src=' . $row[ "image" ] . ' alt="album thumbnail for' . $row[ "album_name" ] . '">
        
                        <div class="card-body text-left pl-0">
    
                            <b>' . $row[ "album_name" ] . '</b> <br>
                            <span class="text-muted">' . $row[ "description" ] . '</span>
                            
                            <a href="album.php?album_id=' . $row[ "album_id" ] . '" class="stretched-link"></a>
    
                         </div>
                     </div>' );

            } ?>

        </div>

    </div>


    <!-- Display all artists -->
    <div class="display-4 my-4">By Artist</div>

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container w-1200">

        <div class="slick-carousel">

            <?php

            //Fetch more album data but group by artist as to only return one per artist
            $statement = $connection->prepare( "SELECT * FROM album GROUP BY artist;" );
            $statement->execute();

            $result = $statement->get_result();
            ////////////////////////////////////////

            //Loop through and create cards for each artist using the album data
            while ( $row = mysqli_fetch_assoc( $result ) ) {


                echo( '                  
                    <div class="card m-3 border-0 underline-hover" style="max-width: 16rem;">
        
                        <img class="card-img-top rounded" src=' . $row[ "image" ] . ' alt="album thumbnail for' . $row[ "artist" ] . '">
        
                        <div class="card-body text-left pl-0">
    
                            <b>' . $row[ "artist" ] . '</b> <br>
                            <span class="text-muted">' . $row[ "description" ] . '</span>
                            
                            <a href="artist.php?artist=' . urlencode( $row[ "artist" ] ) . '" class="stretched-link"></a>
    
                         </div>
                     </div>' );

            } ?>

        </div>

    </div>

    <!-- Display all genres -->
    <div class="display-4 my-4">By Genre</div>

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container w-1200">

        <div class="slick-carousel">

            <?php

            //Fetch tracks grouped by genre in order to create cards for each genre
            $statement = $connection->prepare( "SELECT * FROM tracks GROUP BY genre;" );
            $statement->execute();

            $result = $statement->get_result();
            ///////////////////////////////////////

            //Loop through the tracks and create cards for each genre
            while ( $row = mysqli_fetch_assoc( $result ) ) {


                echo( '                  
                    <div class="card m-3 border-0 underline-hover" style="max-width: 16rem;">
        
                        <img class="card-img-top rounded" src="images/filler_image.jpg" alt="album thumbnail for'
                    . $row[ "genre" ] . '">
        
                        <div class="card-body text-left pl-0">
    
                            <b>' . $row[ "genre" ] . '</b> <br>
                            <span class="text-muted">Genre description</span>
                            
                            <a href="genre.php?genre=' . urlencode( $row[ "genre" ] ) . '" class="stretched-link"></a>
    
                         </div>
                     </div>' );

            } ?>

        </div>

    </div>

</div>

<!-- Footer -->
<div class="navbar footer bg-primary">

    <div class="row text-white">

        <div class="col w-1200 justify-content-center">
            <i class="fab fa-twitter fa-4x px-4"></i>
            <i class="fab fa-facebook fa-4x px-4"></i>
            <i class="fab fa-instagram fa-4x px-4"></i>
        </div>

    </div>

</div>


<!-- Add the js for slick slider -->
<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>

    //Script for slick slider

    $(document).ready(function () {
        $('.slick-carousel').slick({
            infinite: true,
            arrows: true,
            slidesToShow: 5,
            slidesToScroll: 2,


            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        centerMode: false,
                        slidesToShow: 5,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        centerMode: true,
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {

                        centerMode: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

            ]

        });
    });
</script>

</body>

</html>
