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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>
<body>

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
                    <a class="nav-link px-4" href="#">Link</a>
                </li>

                <li class="nav-item float-right">
                    <a class="nav-link px-4" href="#">Link</a>
                </li>

                <li class="nav-item float-right">
                    <a class="nav-link border-left px-4 py-0 my-2" href="#">Link</a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<div class="row text-lg-left text-sm-center bg-primary p-5 text-white">

    <div class="col-xl-9 col-lg-11 mx-auto w-1200">

        <div class="row py-4">

            <div class="col-xl-9 col-lg-10 text-lg-left ">
                <h1 class="display-2">Potify Music</h1>
                <p>Music for everyone.</p>
            </div>

            <div class="col-xl"></div>

        </div>
    </div>
</div>

<div class="row justify-content-center">

    <div class="col w-1200">
        <div class="row justify-content-center">

            <!-- Card 1 - Silver -->
            <div class="col-8 col-lg-3 py-2">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h5 class="text-uppercase text-muted">Silver</h5>
                        <span class="display-3">£3 </span><span class="period">/ Month</span>
                    </div>


                    <div class="card-body">
                        Blah blah blah
                    </div>

                    <div class="card-foooter">
                        £Free!
                    </div>

                </div>
            </div>

            <!-- Card 2 - Gold -->
            <div class="col-8 col-lg-3 py-2">
                <div class="card h-100">

                    <div class="card-header text-center">
                        <h5 class="text-uppercase text-muted">Gold</h5>
                        <span class="display-3">£6 </span><span class="period">/ Month</span>
                    </div>

                    <div class="card-body">
                        Blah blah blah
                    </div>

                    <div class="card-foooter">
                        £Free!
                    </div>

                </div>
            </div>

            <!-- Card 3 - Platinum -->
            <div class="col-8 col-lg-3 py-2">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h5 class="text-uppercase text-muted">Platinum</h5>
                        <span class="display-3">£10 </span><span class="period">/ Month</span>
                    </div>

                    <div class="card-body">
                        Blah blah blah
                    </div>

                    <div class="card-foooter">
                        £Free!
                    </div>

                </div>
            </div>

            <!-- Card 4 - Family -->
            <div class="col-8 col-lg-3 py-2">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h5 class="text-uppercase text-muted">Family</h5>

                        <hr>

                        <span class="display-3">£15 </span><span class="period">/ Month</span>
                    </div>

                    <div class="card-body">
                        Blah blah blahBlah blah blahBlah blah blah
                    </div>

                    <div class="card-foooter">
                        £Free!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid text-center text-white bg-primary" style="margin-bottom:0">
    <p>Footer</p>
</div>

</body>
</html>
