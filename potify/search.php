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
    ?>

</head>
<body class="bg-primary">

<?php

//Check if a search term was submitted, if so then redirect to the search results
if ( isset( $_POST[ "query" ] ) and $_POST[ "query" ] != "" ) {

    $query = htmlspecialchars( $_POST[ "query" ] );

    header( "Location: search-results.php?query=" . $query );

}

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

                    <li class="nav-item float-right active">
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

<div class="container-fluid text-left text-white h-auto" style="padding-top: 20vh;">

    <!-- Max width container to keep content centered on a wide screen -->
    <div class="container mx-auto w-1200">

        <h1 class="display-2 my-4">Search</h1>
        <p>Try searching for a track name, artist name or album name!</p>

        <!-- Search form -->
        <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ "PHP_SELF" ] ); ?>">
            <div class="form-group w-500 my-5">
                <input type="text" class="form-control" placeholder="Search" name="query"/>

                <input type="submit" name="submit" value="Submit" class="btn btn-secondary mt-3 font"/>
            </div>
        </form>

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

</body>

</html>
