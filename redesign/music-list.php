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
    ?>

</head>
<body>

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
                        <a class="nav-link px-4 active" href="music-list.php">Track list</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link border-left px-4 py-0 my-2" href="logout.php">Log out</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>

<div class="container-fluid text-lg-left text-sm-center bg-primary text-white"
     style="padding-top: 10vh; padding-bottom: 10vh">

    <div class="container mx-auto w-1200">

        <div class="row py-4">

            <div class="col-xl-9 col-lg-10">

                <h1 class="display-2">Our Music</h1>
                <p>Browse all our music here</p>

            </div>

            <div class="col-xl"></div>

        </div>
    </div>
</div>


<div class="container-fluid text-center ">

    <div class="display-4 my-4">All Albums</div>

    <div class="row flex-nowrap overflow-auto">

        <?php

        $query = mysqli_query( $connection, "SELECT * FROM album;" );

        while ( $row = mysqli_fetch_assoc( $query ) ) {


            $image = $row[ "image" ];

            echo( '
            <!-- Card 1 - Silver -->
            <div class="col-auto">
                
                <div class="card m-3 border-0 underline-hover" style="max-width: 16rem;">
    
                    <img class="card-img-top rounded" src=' . $image . '>
    
                    <div class="card-body pl-0">

                        <b>' . $row[ "album_name" ] . '</b> <br>
                        <span class="text-muted">' . $row[ "description" ] . '</span>
                        
                        <a href="album.php?album_id=' . $row[ "album_id" ] . '" class="stretched-link"></a>

                     </div>
                 </div>
             </div>' );

        }
        ?>
    </div>
</div>

<div class="container-fluid" style="height: 10vh;">
    <div class="row text-center text-white bg-primary justify-content-center pt-3" style="height: 100%;">
        <div class="col w-1200 justify-content-center">
            <i class="fab fa-twitter fa-4x px-4"></i>
            <i class="fab fa-facebook fa-4x px-4"></i>
            <i class="fab fa-instagram fa-4x px-4"></i>
        </div>
    </div>
</div>

</body>
</html>
