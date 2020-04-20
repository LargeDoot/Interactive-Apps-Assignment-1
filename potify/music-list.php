<!DOCTYPE html>

<!-- Template used from https://www.w3schools.com/bootstrap4/tryit.asp?filename=trybs_template1 -->
<!-- Slick carousel used from https://github.com/kenwheeler/slick -->

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


    <!-- Import the slick slider styles -->
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

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
                        <a class="nav-link px-4 active" href="music-list.php">Albums</a>
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

                <h1 class="display-2">Our Music</h1>
                <p>Browse all our music here</p>

            </div>

            <div class="col-xl"></div>

        </div>
    </div>
</div>


<div class="container-fluid text-center ">

    <!-- Display all albums -->
    <div class="display-4 my-4">All Albums</div>

        <div class="container w-1200">

            <div class="slick-carousel">

            <?php

            $statement = $connection->prepare("SELECT * FROM album;");
            $statement->execute();
            $result = $statement->get_result();

            while ( $row = mysqli_fetch_assoc( $result ) ) {


                $image = $row[ "image" ];

                echo( '                  
                    <div class="card m-3 border-0 underline-hover" style="max-width: 16rem;">
        
                        <img class="card-img-top rounded" src=' . $image . '>
        
                        <div class="card-body text-left pl-0">
    
                            <b>' . $row[ "album_name" ] . '</b> <br>
                            <span class="text-muted">' . $row[ "description" ] . '</span>
                            
                            <a href="album.php?album_id=' . $row[ "album_id" ] . '" class="stretched-link"></a>
    
                         </div>
                     </div>
                 ' );

            }
            ?>
        </div>
    </div>


    <!-- Display all artists -->
    <div class="display-4 my-4">All Albums</div>

    <div class="container w-1200">

        <div class="slick-carousel">

            <?php

            $statement = $connection->prepare("SELECT * FROM album;");
            $statement->execute();
            $result = $statement->get_result();

            while ( $row = mysqli_fetch_assoc( $result ) ) {


                $image = $row[ "image" ];

                echo( '                  
                    <div class="card m-3 border-0 underline-hover" style="max-width: 16rem;">
        
                        <img class="card-img-top rounded" src=' . $image . '>
        
                        <div class="card-body text-left pl-0">
    
                            <b>' . $row[ "album_name" ] . '</b> <br>
                            <span class="text-muted">' . $row[ "description" ] . '</span>
                            
                            <a href="album.php?album_id=' . $row[ "album_id" ] . '" class="stretched-link"></a>
    
                         </div>
                     </div>
                 ' );

            }
            ?>
        </div>
    </div>

</div>

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
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.slick-carousel').slick({
            infinite: true,
            arrows: true,
            slidesToShow: 5,
            slidesToScroll:2,


            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        centerMode:false,
                        slidesToShow: 5,
                        slidesToScroll:2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        centerMode:true,
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {

                        centerMode:true,
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
