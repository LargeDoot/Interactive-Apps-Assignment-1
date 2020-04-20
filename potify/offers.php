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

    <?php include( "db_connection.php" ); ?>

</head>
<body>

<div class="container-fluid">

    <nav class="navbar fixed-top navbar-expand-sm bg-primary navbar-dark">

        <div class="container w-1200">

            <a href="index.php" class="navbar-brand">
                <img src="images/Potify_Logo.png" alt="Potify icon">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="collapsibleNavbar">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item float-right">
                        <a class="nav-link px-4 active" href="offers.php">Go Premium</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link border-left px-4 py-0 my-2" href="register.php">Register</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="login.php">Login</a>
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

                <h1 class="display-2">Try Potify free for one month</h1>
                <p>From £3 / month thereafter</p>

            </div>

            <div class="col-xl"></div>

        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="container w-1200 justify-content-center">

        <div class="display-4 py-4 text-center">Pick your package</div>

        <div class="row my-3">

            <?php
            //Get details of available offers
            $statement = $connection->prepare("SELECT * FROM offers;");
            $statement->execute();
            $result = $statement->get_result();


            while ( $row = mysqli_fetch_assoc( $result ) ) {

                echo( '
                    <!-- Create cards -->
                    <div class="col-11 col-lg-3 py-2">
                        <div class="card h-100">
        
                            <div class="card-header text-center">
                                <h5 class="text-uppercase text-muted">
                                    ' . $row[ "title" ] . '
                                </h5>
                                <hr>
                                <span class="display-3">
                                    £
                                    ' . $row[ "price" ] . '
                                </span><span class="period">/ Month</span>
                            </div>
        
        
                            <div class="card-body">
                                <ul>
                                    ' . $row[ "description" ] . '
                                </ul>
                            </div>
        
                            <div class="card-footer text-center">
                                <a class="btn btn-secondary" href="register.php">Get started</a>
                            </div>
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

</body>
</html>
